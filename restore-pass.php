<?php
session_start();

if (isset($_SESSION['userData'])) {
    header("Location: user.php");
    die;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" type="image/png" href="https://i.ibb.co/KFBHvHY/frameme-logo.png" title="favicon">
    <title>Frame Me - Logga in</title>
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

    <main>
        <div class="content">

            <div class='login-error hidden'>E-post adressen är inte registrerad.</div>

            <form onsubmit="shopLib.restorePassword(event)" method="POST" class="checkout-form">

            <!-- Left side, delivery section -->
            <div class="checkout-form__container">
                <section class="checkout-form__delivery-section">

                    <h2 class="checkout-form__delivery-section__h2">Återställ lösenordet</h2>

                    <label class="checkout-form__delivery-section__label">E-post</label>
                    <input class="checkout-form__delivery-section__input" id="email" type="email" name="email" maxlength=254>

                    <div id="restorepass-success-msg" class="greenText"></div>
                    <div id="restorepass-error-msg" class="redText"></div>

                    <button type="submit" class="checkout-form__delivery-section__deliveryBtn">Återställ lösenordet</button>

                </section>
            </form>

        </div>
    </main>

    <?php require_once __DIR__ . '/php/view/footer.php';?>

    <!-- js scripts go here -->
    <?php require_once __DIR__ . '/php/view/jscore.php';?>

</body>

</html>