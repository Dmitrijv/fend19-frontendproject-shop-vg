<?php

require_once __DIR__ . "/../model/db.php";

ini_set('SMTP', "cpsrv48.misshosting.com");
ini_set('smtp_port', "465");
ini_set('sendmail_from', "frameme@noreply.se");
ini_set('sendmail_path', "/usr/sbin/sendmail");

function doesProductIdExist($productId)
{
    return DB::run("SELECT EXISTS(SELECT * FROM product WHERE id = ?)", [$productId])->fetchColumn();
}

function getProductById($productId)
{

    $newIds = getNewlyInStockProductIds();
    $oldIds = getLastChanceProductIds();

    $tableRow = DB::run("
        SELECT product.id as id,
        product.title,
        product_category.name as category,
        product_category.id as categoryId,
        product.description,
        price_of_product.amount as price,
        product.number_in_stock
        FROM product, product_category, price_of_product
        WHERE product.category_id = product_category.id
        AND product.id = price_of_product.product_id
        AND product.id = ?
    ", [$productId])->fetch(PDO::FETCH_LAZY);

    $product = [
        "id" => $tableRow['id'],
        "title" => $tableRow['title'],
        "description" => $tableRow['description'],
        "category" => $tableRow['category'],
        "categoryId" => $tableRow['categoryId'],
        "price" => $tableRow['price'],
        "currency" => $tableRow['currency'],
        "number_in_stock" => $tableRow['number_in_stock'],
    ];

    // check if it's a newly added product
    if (isset($newIds[$productId])) {
        $product['new'] = true;
        // check if it's a "last chance" product
    } elseif (isset($oldIds[$productId])) {
        $product['old'] = true;
        $product['price'] = round(intval($product['price']) * 0.9, 2);
    }

    // get images for this product from the database
    $product['gallery'] = getProductImages($productId);

    return $product;

}

function getProductImages($productId)
{
    $stmt = DB::run("SELECT DISTINCT file_name FROM image_of_product WHERE product_id = ?", [$productId]);
    $response = [];
    while ($tableRow = $stmt->fetch(PDO::FETCH_LAZY)) {
        array_push($response, $tableRow['file_name']);
    }
    return $response;
}

function getNewlyInStockProductIds()
{
    // get ids of new products
    $newIds = [];
    $newIdsSql = DB::run("
        SELECT id
        FROM product
        WHERE number_in_stock > 0
        ORDER BY id DESC
        LIMIT 4
    ");
    while ($tableRow = $newIdsSql->fetch(PDO::FETCH_LAZY)) {
        $newIds[$tableRow['id']] = true;
    }
    return $newIds;
}

function getLastChanceProductIds()
{

    $oldIds = [];
    $oldIdsSql = DB::run("
        SELECT id
        FROM product
        WHERE number_in_stock > 0
        ORDER BY id ASC
        LIMIT 4
    ");
    while ($tableRow = $oldIdsSql->fetch(PDO::FETCH_LAZY)) {
        $oldIds[$tableRow['id']] = true;
    }
    return $oldIds;
}

function createNewOrder($order)
{
    $userId = (isset($order['user_id'])) ? $order['user_id'] : 0;
    $sql = "
        INSERT INTO active_order_of_products (date_ordered_at, status, customer_data_id, free_shipping, user_id)
        VALUES (?, 1, ?, ?, ?)
    ";
    DB::run($sql, [$order['date_ordered_at'], $order['customer_data_id'], $order['free_shipping'], $userId]);
}

function getOrderIdByTimeAndUser($date_ordered_at, $customer_data_id)
{
    return DB::run("
        SELECT id
        FROM active_order_of_products
        WHERE date_ordered_at = ?
        AND customer_data_id = ?
    ", [$date_ordered_at, $customer_data_id])->fetchColumn();
}

function saveCustomerDataToDb($id, $data)
{
    $sql = "
        INSERT INTO customer_data (id, email, phone, first_name, last_name, street, postal_number, county)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ";
    DB::run($sql, [$id, $data['email'], $data['phone'], $data['first_name'], $data['last_name'], $data['street'], $data['postal_number'], $data['county']]);
}

function doesCustomerDataIdExist($id)
{
    return DB::run("SELECT EXISTS(SELECT * FROM customer_data WHERE id = ?)", [$id])->fetchColumn();
}

function createOrderedProduct($orderId, $product, $quantity)
{

    $productId = intval($product['id']);

    $sql = "
        INSERT INTO ordered_product (product_id, order_id, price, quantity, currency_id)
        VALUES (?, ?, ?, ?, ?)
    ";
    DB::run($sql, [$productId, $orderId, $product['price'], $quantity, "SEK"]);

    $newNumberInStock = intval($product['number_in_stock']) - $quantity;
    // this should never happen in theory because order process doesn't let you order more than there is in stock
    if ($newNumberInStock < 0) {
        $newNumberInStock = 0;
    }

    // remove ordered items from stoc
    DB::run("UPDATE product SET number_in_stock = ? WHERE id = ?", [$newNumberInStock, $productId]);

}

function createNewUser($user)
{
    $sql = "
        INSERT INTO user (email, password, customer_data_id)
        VALUES (?, ?, ?)
    ";
    DB::run($sql, [$user['email'], $user['password'], $user['customer_data_id']]);
}

function isEmailRegistered($email)
{
    return DB::run("SELECT EXISTS(SELECT * FROM user WHERE email = ?)", [$email])->fetchColumn();
}

function getUserIdByEmail($email)
{
    return DB::run("SELECT id FROM user WHERE email = ?", [$email])->fetchColumn();
}

function isCorrectPassword($password, $email)
{
    $storedHash = DB::run("SELECT password FROM user WHERE email = ?", [$email])->fetchColumn();
    return password_verify($password, $storedHash);
}

function getCustomerDataByUserEmail($email)
{
    $sql = "
        SELECT user.id as user_id, customer_data.*
        FROM user, customer_data
        WHERE customer_data.id = user.customer_data_id
        AND user.email = ?
    ";
    return DB::run($sql, [$email])->fetch(PDO::FETCH_ASSOC);
}

function getActiveUserOrders($user_id, $customer_data_id)
{
    $stmt = DB::run("
        SELECT
            active_order_of_products.id as id,
            active_order_of_products.date_ordered_at as date_ordered_at,
            customer_data.county as county,
            active_order_of_products.status as status_id,
            SUM(ordered_product.price * ordered_product.quantity) as order_total,
            SUM(ordered_product.quantity) as item_count,
            order_status.name as status_name,
            active_order_of_products.free_shipping as free_shipping
        FROM
            active_order_of_products,
            order_status,
            ordered_product,
            customer_data
        WHERE
            active_order_of_products.status = order_status.id
            AND ordered_product.order_id = active_order_of_products.id
            AND active_order_of_products.customer_data_id = customer_data.id
            AND (active_order_of_products.user_id = ? OR active_order_of_products.customer_data_id = ?)
        GROUP BY
            active_order_of_products.id
        ORDER BY
            date_ordered_at DESC
    ", [$user_id, $customer_data_id]);
    $response = [];
    while ($tableRow = $stmt->fetch(PDO::FETCH_LAZY)) {
        $order = [
            "id" => $tableRow['id'],
            "date_ordered_at" => $tableRow['date_ordered_at'],
            "county" => $tableRow['county'],
            "status_id" => $tableRow['status_id'],
            "status_name" => $tableRow['status_name'],
            "order_total" => $tableRow['order_total'],
            "free_shipping" => $tableRow['free_shipping'],
            "item_count" => $tableRow['item_count'],
        ];
        array_push($response, $order);
    }
    return $response;
}

function getCompletedUserOrders($user_id, $customer_data_id)
{
    $stmt = DB::run("
        SELECT
            completed_order_of_products.id as id,
            completed_order_of_products.date_ordered_at as date_ordered_at,
            customer_data.county as county,
            completed_order_of_products.status as status_id,
            SUM(delivered_product.price) as order_total,
            COUNT(delivered_product.product_id) as item_count,
            order_status.name as status_name,
            completed_order_of_products.free_shipping as free_shipping
        FROM
            completed_order_of_products,
            order_status,
            delivered_product,
            customer_data
        WHERE
            completed_order_of_products.status = order_status.id
            AND delivered_product.order_id = completed_order_of_products.id
            AND completed_order_of_products.customer_data_id = customer_data.id
            AND (completed_order_of_products.user_id = ? OR completed_order_of_products.customer_data_id = ?)
        GROUP BY
            completed_order_of_products.id
        ORDER BY
            date_ordered_at DESC
    ", [$user_id, $customer_data_id]);
    $response = [];
    while ($tableRow = $stmt->fetch(PDO::FETCH_LAZY)) {
        $order = [
            "id" => $tableRow['id'],
            "date_ordered_at" => $tableRow['date_ordered_at'],
            "county" => $tableRow['county'],
            "status_id" => $tableRow['status_id'],
            "status_name" => $tableRow['status_name'],
            "order_total" => $tableRow['order_total'],
            "free_shipping" => $tableRow['free_shipping'],
            "item_count" => $tableRow['item_count'],
        ];
        array_push($response, $order);
    }
    return $response;
}

function getOrderByIdAndStatus($orderId, $statusId)
{
    $targetTable = ($statusId == 3) ? "completed_order_of_products" : "active_order_of_products";
    return DB::run("
        SELECT " . $targetTable . ".*, order_status.name as status_name
        FROM " . $targetTable . ",
        order_status
        WHERE " . $targetTable . ".id = ?
        AND status = order_status.id
    ", [$orderId])->fetch(PDO::FETCH_ASSOC);
}

function getCustomerDataById($customerId)
{
    return DB::run("
        SELECT *
        FROM customer_data
        WHERE id = ?
    ", [$customerId])->fetch(PDO::FETCH_ASSOC);
}

function getProductsByOrderIdAndStatus($orderId, $statusId)
{
    $targetTable = ($statusId == 3) ? "delivered_product" : "ordered_product";

    $stmt = DB::run("
        SELECT *
        FROM " . $targetTable . "
        WHERE " . $targetTable . ".order_id = ?
    ", [$orderId]);

    $response = [];
    while ($tableRow = $stmt->fetch(PDO::FETCH_LAZY)) {
        $product = [
            "product_id" => $tableRow['product_id'],
            "order_id" => $tableRow['order_id'],
            "price" => $tableRow['price'],
            "quantity" => $tableRow['quantity'],
        ];
        array_push($response, $product);
    }
    return $response;
}

function setUserPassword($user_id, $newPassword)
{
    DB::run("UPDATE user SET password=? WHERE id=?", [$newPassword, $user_id]);
}
