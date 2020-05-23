<?php

session_start();

if (!isset($_SESSION['userData'])) {
    header("Location: login.php");
    die;
}

require_once __DIR__ . "/php/controller/controller.php";

$customerData = $_SESSION['userData'];
$user_id = intval($customerData['user_id']);
$customer_data_id = $customerData["id"];

$orderTableHtml = '';

// build html for active orders
$activeOrders = getActiveUserOrders($user_id, $customer_data_id);
foreach ($activeOrders as &$order) {
    $orderTableHtml = $orderTableHtml . '
        <tr>
            <td class="linkContainer">
                <a href="invoice.php?orderId=' . $order['id'] . '&orderStatus=' . $order['status_id'] . '">' . $order['id'] . '</a>
            </td>
            <td>' . $order['status_name'] . '</td>
            <td>' . $order['date_ordered_at'] . '</td>
            <td>' . $order['order_total'] . ' kr</td>
        </tr>
    ';
}

// build html for completed orders
$completedOrders = getCompletedUserOrders($user_id, $customer_data_id);
foreach ($completedOrders as &$order) {
    $orderTableHtml = $orderTableHtml . '
        <tr>
            <td class="linkContainer">
                <a href="invoice.php?orderId=' . $order['id'] . '&orderStatus=' . $order['status_id'] . '">' . $order['id'] . '</a>
            </td>
            <td>' . $order['status_name'] . '</td>
            <td>' . $order['date_ordered_at'] . '</td>
            <td>' . $order['order_total'] . ' kr</td>
        </tr>
    ';
}

// hide empty order list message if there are more than 0 orders
$orderListMsgClassList = ((count($activeOrders) + count($completedOrders)) > 0) ? "hidden" : "";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" type="image/png" href="https://i.ibb.co/KFBHvHY/frameme-logo.png" title="favicon">
    <title>Frame Me - User</title>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="single-product-page__body">

    <span class="hamburger__bar-wrapper">
        <span class="hamburger__bar"></span>
        <span class="hamburger__bar"></span>
        <span class="hamburger__bar"></span>
    </span>

    <?php require_once __DIR__ . '/php/view/sidebar.php';?>
    <?php require_once __DIR__ . '/php/view/header.php';?>
    <?php require_once __DIR__ . '/php/view/cart.php';?>

    <main>
        <div class="content">
            <div class="user-content">
                <!-- user details -->
                <section class="user-details white-panel">
                    <div class="panel-heading">Dina uppgifter</div>
                    <dl class="user-summary panel-content" >
                        <dt>Kundnamn</dt>
                        <dd id="fullname"><?php echo htmlspecialchars($customerData['first_name'] . " " . $customerData['last_name'], ENT_QUOTES, 'UTF-8'); ?></dd>
                        <dt>Telefon</dt>
                        <dd id="phone"><?php echo htmlspecialchars($customerData['phone'], ENT_QUOTES, 'UTF-8'); ?></dd>
                        <dt>E-post</dt>
                        <dd id="email"> <?php echo htmlspecialchars($customerData['email'], ENT_QUOTES, 'UTF-8'); ?> </dd>
                        <dt>Adress</dt>
                        <dd id="address"><?php echo htmlspecialchars($customerData['street'] . ", " . $customerData['postal_number'] . ", " . $customerData['county'], ENT_QUOTES, 'UTF-8'); ?></dd>
                    </dl>
                    <div class="change-btn-container">
                        <button type="button" class="changeInput">Ändra uppgifter</button>
                    </div>
                </section>
                <!-- purchase history -->
                <section class="purchase-history white-panel">
                    <div class="panel-heading">Dina beställningar</div>
                    <div class="panel-content" >
                        <h2 class="empty-order-list-message <?php echo $orderListMsgClassList; ?>" >Du har inte gjort några köp än.</h2>
                        <table class="db-table category-table">
                            <thead>
                                <tr>
                                    <th>Ordernr</th>
                                    <th>Status</th>
                                    <th>Datum</th>
                                    <th>Ordervärde</th>
                                </tr>
                            </thead>
                            <tbody id="userOrdersTableBody">
                                <?php echo $orderTableHtml; ?>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>
    </main>

    <?php require_once __DIR__ . '/php/view/footer.php';?>

    <!-- js scripts go here -->
    <?php require_once __DIR__ . '/php/view/jscore.php';?>

</body>

</html>