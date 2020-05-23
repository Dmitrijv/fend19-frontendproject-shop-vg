<?php

session_start();

require_once __DIR__ . "/php/controller/controller.php";

// invalid request
if (
    !isset($_SESSION['userData'])
    || !isset($_SESSION['userData']['user_id'])
    || !isset($_GET['orderId'])
    || !is_numeric($_GET['orderId'])
    || !isset($_GET['orderStatus'])
    || !is_numeric($_GET['orderStatus'])
) {
    header("Location: error.php?errorMessage=Kunde inte visa fakturan.</br>Detta kan bero på att ordern inte finns eller att du inte har rättigheter att se ordern.</br>Logga in på kontot som ordern tillhör och försök igen.");
    die;
}

$orderId = intval($_GET['orderId']);
$statusId = intval($_GET['orderStatus']);

$order = getOrderByIdAndStatus($orderId, $statusId);

// missing order
if (
    !isset($order)
) {
    header("Location: error.php?errorMessage=Kunde inte visa fakturan.</br>Detta kan bero på att ordern inte finns eller att du inte har rättigheter att se ordern.</br>Logga in på kontot som ordern tillhör och försök igen.");
    die;
}

// requesting restricted information
$isEligible = isset($order) && (intval($_SESSION['userData']['user_id']) == $order['user_id'] || $_SESSION['userData']['user_id'] == $order['customer_data_id']);
if (!$isEligible) {
    header("Location: error.php?errorMessage=Kunde inte visa fakturan.</br>Detta kan bero på att ordern inte finns eller att du inte har rättigheter att se ordern.</br>Logga in på kontot som ordern tillhör och försök igen.");
    die;
}

// invalid order id
if (!isset($order['id'])) {die;}

$customerId = $order['customer_data_id'];
$customerData = getCustomerDataById($customerId);
$shoppingCart = getProductsByOrderIdAndStatus($orderId, $statusId);

$productListHtml = '';
$totalAmount = 0;
$finalPriceAmount = 0;
foreach ($shoppingCart as &$cartItem) {

    $productId = intval($cartItem['product_id']);
    $orderedQuantity = intval($cartItem['quantity']);
    $totalAmount += $orderedQuantity;
    $itemTotalPrice = intval($cartItem['price']) * $orderedQuantity;

    $product = getProductById($productId);

    $gallery = getProductImages($productId);
    $coverImage = "placeholder.png";
    if (count($gallery) != 0) {
        $coverImage = $gallery[0];
    }

    $finalPriceAmount += $itemTotalPrice;
    $productListHtml = $productListHtml . '
        <tr>
            <td class="item-image">
                <img class="product-cover-small" src="img/product/' . $coverImage . '" alt="' . $product["title"] . '">
            </td>
            <td class="item-name"><a target="_blank" href="product.php?productId=' . $product['id'] . '" >' . $product['title'] . '</a></td>
            <td class="item-qty">' . $orderedQuantity . '</td>
            <td class="item-price">' . $cartItem['price'] . ' kr</td>
            <td class="item-total">' . $itemTotalPrice . ' kr</td>
        </tr>';
}

$shipping_message = "Frakt: 0 kr";
if ($order['free_shipping'] == 0) {
    $finalPriceAmount = intval($finalPriceAmount) + 50;
    $shipping_message = "Frakt: 50 kr";
}

$productListHtml .= '
    <tr class="font-bold">
        <td>Totalt:</td>
        <td></td>
        <td class="products-amount">' . $totalAmount . '</td>
        <td>' . $shipping_message . '</td>
        <td class="item-total">' . $finalPriceAmount . ' kr</td>
    </tr>';

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" type="image/png" href="https://i.ibb.co/KFBHvHY/frameme-logo.png" title="favicon">
    <title>Frame Me | Faktura</title>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body id="order-body">

    <span class="hamburger__bar-wrapper">
        <span class="hamburger__bar"></span>
        <span class="hamburger__bar"></span>
        <span class="hamburger__bar"></span>
    </span>

    <?php require_once __DIR__ . '/php/view/sidebar.php';?>
    <?php require_once __DIR__ . '/php/view/header.php';?>
    <?php require_once __DIR__ . '/php/view/cart.php';?>

        <main id="order-main">

            <!-- CONTENT area begins -->
            <section class="order-confirmation white-panel">

                <div class="panel-heading">Order Information</div>

                <div class="order-description">
                    <dl>
                        <dt>Ordernummer:</dt>
                        <dd id="orderNumber"><?php echo $order["id"]; ?></dd>
                        <dt>Order status:</dt>
                        <dd id="orderNumber"><?php echo $order["status_name"]; ?></dd>

                        <dt>Beställningsdatum:</dt>
                        <dd class="dateToday"><?php echo $order['date_ordered_at']; ?></dd>
                        </br>

                        <dt>Kundnamn</dt>
                        <dd id="fullname"><?php echo htmlspecialchars($customerData['first_name'] . " " . $customerData['last_name'], ENT_QUOTES, 'UTF-8'); ?></dd>
                        <dt>Telefon</dt>
                        <dd id="phone"><?php echo htmlspecialchars($customerData['phone'], ENT_QUOTES, 'UTF-8'); ?></dd>
                        <dt>Email</dt>
                        <dd id="email"> <?php echo htmlspecialchars($customerData['email'], ENT_QUOTES, 'UTF-8'); ?> </dd>
                        <dt>Adress</dt>
                        <dd id="address"><?php echo htmlspecialchars($customerData['street'] . ", " . $customerData['postal_number'] . ", " . $customerData['county'], ENT_QUOTES, 'UTF-8'); ?></dd>
                        </br>

                    </dl>
                </div>

                <table>
                    <thead class="font-bold">
                        <tr>
                            <th></th>
                            <th>Produkt</th>
                            <th>Antal</th>
                            <th>Pris</th>
                            <th class="item-total">Totalt</th>
                        </tr>
                    </thead>
                    <tbody class="order-list">
                        <?php echo $productListHtml; ?>
                    </tbody>
                </table>

                <a href="user.php">
                    <button class="btn btn-info goback-Btn">Till Profil Sidan</button>
                </a>

            </div>
            </section>
            <!-- CONTENT area ends -->

        </main>

        <?php require_once __DIR__ . '/php/view/jscore.php';?>

    </body>


</html>
