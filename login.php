
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" type="image/png" href="https://i.ibb.co/KFBHvHY/frameme-logo.png" title="favicon">
    <title>Frame Me - Login</title>
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

            <div class='login-error hidden'>Ogiltigt mail eller lösenord.</div>

            <form onsubmit="shopLib.login()" method="POST" class="checkout-form">

            <!-- Left side, delivery section -->
            <div class="checkout-form__container">
                <section class="checkout-form__delivery-section">

                    <div class="err-tips"></div>

                    <h2 class="checkout-form__delivery-section__h2">Logga in</h2>

                    <label class="checkout-form__delivery-section__label">e-postadress</label>
                    <input class="checkout-form__delivery-section__input" id="email" type="email" name="email" maxlength=254>

                    <label class="checkout-form__delivery-section__label">lösenord</label>
                    <input class="checkout-form__delivery-section__input" id="pass" type="password" name="pass" maxlength=20>

                    <button type="submit" class="checkout-form__delivery-section__deliveryBtn">logga in</button>

                </section>
            </form>

        </div>
    </main>

    <?php require_once __DIR__ . '/php/view/footer.php';?>

    <!-- js scripts go here -->
    <?php require_once __DIR__ . '/php/view/jscore.php';?>

</body>

</html>