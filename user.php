<?php

session_start();

if (
    !isset($_SESSION['userData'])
    || !isset($_SESSION['userData']['user_id'])
) {
    header("Location: login.php");
    die;
}

require_once __DIR__ . "/php/controller/controller.php";

$defaultEmail = (isset($_SESSION['userData']["email"])) ? htmlspecialchars($_SESSION['userData']["email"], ENT_QUOTES, 'UTF-8') : "";
$defaultFname = (isset($_SESSION['userData']["first_name"])) ? htmlspecialchars($_SESSION['userData']["first_name"], ENT_QUOTES, 'UTF-8') : "";
$defaultLname = (isset($_SESSION['userData']["last_name"])) ? htmlspecialchars($_SESSION['userData']["last_name"], ENT_QUOTES, 'UTF-8') : "";
$defaultPhonenum = (isset($_SESSION['userData']["phone"])) ? htmlspecialchars($_SESSION['userData']["phone"], ENT_QUOTES, 'UTF-8') : "";
$defaultStreet = (isset($_SESSION['userData']["street"])) ? htmlspecialchars($_SESSION['userData']["street"], ENT_QUOTES, 'UTF-8') : "";
$defaultPostal = (isset($_SESSION['userData']["postal_number"])) ? htmlspecialchars($_SESSION['userData']["postal_number"], ENT_QUOTES, 'UTF-8') : "";
$defaultCounty = (isset($_SESSION['userData']["county"])) ? htmlspecialchars($_SESSION['userData']["county"], ENT_QUOTES, 'UTF-8') : "";

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
$orderTableClassList = ((count($activeOrders) + count($completedOrders)) == 0) ? "hidden" : "";

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

                    <div id="user-details-div" class="">
                        <div class="panel-heading">Dina uppgifter</div>

                        <dl class="user-summary panel-content" >
                            <dt>Kundnamn</dt>
                            <dd id="fullname"><?php echo htmlspecialchars($customerData['first_name'] . " " . $customerData['last_name'], ENT_QUOTES, 'UTF-8'); ?></dd>
                            <dt>Telefon</dt>
                            <dd id="phone"><?php echo htmlspecialchars($customerData['phone'], ENT_QUOTES, 'UTF-8'); ?></dd>
                            <dt>E-post</dt>
                            <dd id="email"> <?php echo $defaultEmail; ?> </dd>
                            <dt>Adress</dt>
                            <dd id="address"><?php echo htmlspecialchars($customerData['street'] . ", " . $customerData['postal_number'] . ", " . $customerData['county'], ENT_QUOTES, 'UTF-8'); ?></dd>
                        </dl>

                        <div class="change-btn-container">
                            <button type="button" id="editUserDetailsButton" class="changeInput">Ändra leveransadress</button>
                        </div>

                    </div>


                    <div id="edit-user-div" class=" hidden">
                        <div class="panel-heading">Ändra leveransadress</div>

                        <form onsubmit="shopLib.updateUserInfo(event)" method="POST" class="edit-user-form panel-content">

                            <!-- Left side, delivery section -->
                            <div class="checkout-form__container">
                                <section class="checkout-form__delivery-section">

                                    <div id="update-user-form-error-msg" class="redText"></div>

                                    <input class="checkout-form__delivery-section__input" required id="email" type="hidden" name="email" value="<?php echo $defaultEmail; ?>">

                                    <label class="checkout-form__delivery-section__label" for="">Förnamn</label>
                                    <input class="checkout-form__delivery-section__input" required id="fname" type="text" name="fname" value="<?php echo $defaultFname; ?>" minlenght=1 maxlength=20>

                                    <label class="checkout-form__delivery-section__label" for="">Efternamn</label>
                                    <input class="checkout-form__delivery-section__input" required id="lname" type="text" name="lname" value="<?php echo $defaultLname; ?>" minlenght=1 maxlength=20>

                                    <label class="checkout-form__delivery-section__label" for="">Telefonnummer</label>
                                    <input class="checkout-form__delivery-section__input" required id="tel" type="text" name="phone" value="<?php echo $defaultPhonenum; ?>" placeholder="073-111 22 33" pattern="0[0-9]{1,3}-?[0-9 ]{6,10}" minlength=8 maxlength=14>

                                    <label class="checkout-form__delivery-section__label" for="">Gatuadress</label>
                                    <input class="checkout-form__delivery-section__input" required id="adress" type="text" name="adress" value="<?php echo $defaultStreet; ?>" placeholder="Gustafvägen 10D" maxlength=50>

                                    <label class="checkout-form__delivery-section__label" for="">Postnummer</label>
                                    <input class="checkout-form__delivery-section__input" required id="pcode" type="text" name="pcode" value="<?php echo $defaultPostal; ?>" placeholder="123 45" maxlength=6 pattern="[0-9]{3,3} [0-9]{2,2}">

                                    <label class="checkout-form__delivery-section__label" for="">Ort</label>
                                    <input class="checkout-form__delivery-section__input" required id="city" type="text" name="county" value="<?php echo $defaultCounty; ?>" placeholder="Stockholm" maxlength=50>

                                    <button type="submit" class="checkout-form__delivery-section__deliveryBtn save-user-btn">Spara</button>
                                    <button type="button" class="checkout-form__delivery-section__deliveryBtn cancel-edit-btn">Avbryt</button>

                                </section>
                            </div>
                        </form>
                    </div>

                </section>

                <!-- purchase history -->
                <section class="purchase-history white-panel">
                    <div class="panel-heading">Dina beställningar</div>
                    <div class="panel-content" >
                        <h2 class="empty-order-list-message <?php echo $orderListMsgClassList; ?>" >Du har inte gjort några köp än.</h2>
                        <table class="db-table category-table <?php echo $orderTableClassList; ?>">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Status</th>
                                    <th>Datum</th>
                                    <th>Värde</th>
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
        <script type="text/javascript" src="./js/user/userDetailsToggler.js"></script>

</body>

</html>