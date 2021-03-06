<?php
session_start();

$defaultEmail = (isset($_SESSION['userData']["email"])) ? htmlspecialchars($_SESSION['userData']["email"], ENT_QUOTES, 'UTF-8') : "";
$defaultFname = (isset($_SESSION['userData']["first_name"])) ? htmlspecialchars($_SESSION['userData']["first_name"], ENT_QUOTES, 'UTF-8') : "";
$defaultLname = (isset($_SESSION['userData']["last_name"])) ? htmlspecialchars($_SESSION['userData']["last_name"], ENT_QUOTES, 'UTF-8') : "";
$defaultPhonenum = (isset($_SESSION['userData']["phone"])) ? htmlspecialchars($_SESSION['userData']["phone"], ENT_QUOTES, 'UTF-8') : "";
$defaultStreet = (isset($_SESSION['userData']["street"])) ? htmlspecialchars($_SESSION['userData']["street"], ENT_QUOTES, 'UTF-8') : "";
$defaultPostal = (isset($_SESSION['userData']["postal_number"])) ? htmlspecialchars($_SESSION['userData']["postal_number"], ENT_QUOTES, 'UTF-8') : "";
$defaultCounty = (isset($_SESSION['userData']["county"])) ? htmlspecialchars($_SESSION['userData']["county"], ENT_QUOTES, 'UTF-8') : "";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" type="image/png" href="https://i.ibb.co/KFBHvHY/frameme-logo.png" title="favicon">
    <title>Frame Me | Checkout</title>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <span class="hamburger__bar-wrapper">
        <span class="hamburger__bar"></span>
        <span class="hamburger__bar"></span>
        <span class="hamburger__bar"></span>
    </span>

    <?php require_once __DIR__ . '/php/view/sidebar.php';?>
    <?php require_once __DIR__ . '/php/view/header.php';?>
    <?php require_once __DIR__ . '/php/view/cart.php';?>


    <main id="checkout-main">

        <!-- <form action="order.php" onsubmit="clearCart()" method="POST" class="checkout-form"> -->
        <form action="order.php"  method="POST" class="checkout-form">
            <!-- Right side: cart section -->
            <section class="checkout-form__cart-section">
                <h2 class="checkout-form__cart-section__h2">Varukorg</h2>
                <div class="checkout-form__cart-section__product-list">
                    <!-- Use Martin's pattern here -->
                </div>

                <div class="checkout-form__cart-section__sum-area">
                    <p class="small-font-size"><strong>Fri frakt!</strong>&nbsp;&nbsp;När du handlar för över 500 kr, eller beställer till en adress i Stockholm.</p>
                    <p class="deliveryFeeRow">Frakt: <span class="deliveryFeeText hidden">50 kr</span></p>
                    <span class="pull-left products-amount"></span>
                    <span class="pull-right totalPrice"></span>
                </div>
                <div class="checkout-form__cart-section__totalsum"></div>
                <button action="index.php" type="button" class="checkout-form__cart-section__keep-shopping-btn">Fortsätt handla</button>
            </section>

            <!-- Left side, delivery section -->
            <div class="checkout-form__container">
                <section class="checkout-form__delivery-section">

                    <div class="err-tips"></div>

                    <h2 class="checkout-form__delivery-section__h2">Fyll i kunduppgifter</h2>

                    <label class="checkout-form__delivery-section__label" for="">Email Adress</label>
                    <input class="checkout-form__delivery-section__input" id="email" type="text" value="<?php echo $defaultEmail; ?>" name="email" placeholder="name@mail.com" maxlength=254>

                    <label class="checkout-form__delivery-section__label" for="">Förnamn</label>
                    <input class="checkout-form__delivery-section__input" id="fname" type="text" value="<?php echo $defaultFname; ?>" name="fname" maxlength=20>

                    <label class="checkout-form__delivery-section__label" for="">Efternamn</label>
                    <input class="checkout-form__delivery-section__input" id="lname" type="text" value="<?php echo $defaultLname; ?>" name="lname" maxlength=20>

                    <label class="checkout-form__delivery-section__label" for="">Telefonnummer</label>
                    <input class="checkout-form__delivery-section__input" id="tel" type="text" value="<?php echo $defaultPhonenum; ?>" name="phone" placeholder="073-111 22 33" pattern="0[0-9]{1,3}-?[0-9 ]{6,10}" maxlength=14>

                    <label class="checkout-form__delivery-section__label" for="">Gatuadress</label>
                    <input class="checkout-form__delivery-section__input" id="adress" type="text" value="<?php echo $defaultStreet; ?>" name="adress" placeholder="Gustafvägen 10D" maxlength=50>

                    <label class="checkout-form__delivery-section__label" for="">Postnummer</label>
                    <input class="checkout-form__delivery-section__input" id="pcode" type="text" value="<?php echo $defaultPostal; ?>" name="pcode" placeholder="123 45" maxlength=7>

                    <label class="checkout-form__delivery-section__label" for="">Ort</label>
                    <input class="checkout-form__delivery-section__input" id="city" type="text" value="<?php echo $defaultCounty; ?>" name="county" maxlength=50>

                    <!-- this is filled from local storage with js -->
                    <input type="hidden" name="shoppingCart" value="">

                    <button type="button" class="checkout-form__delivery-section__deliveryBtn">Leverera till denna adress</button>

                    <button type="button" class="changeInput" disabled>Ändra uppgifter</button>

                </section>

                <section class="checkout-form__btn-section">
                    <button type="submit" class="checkout-form__btn-section__checkoutBtn--dim" disabled="disabled">Genomför köp</button>
                </section>
            </div>

        </form>

    </main>

    <?php require_once __DIR__ . '/php/view/footer.php';?>

    <!-- js scripts go here -->
    <?php require_once __DIR__ . '/php/view/jscore.php';?>

    <!-- Validation & draw cart-section for Checkout -->
    <script type="text/javascript" src="./js/checkout.js"></script>

</body>

</html>