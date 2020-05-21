
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" type="image/png" href="https://i.ibb.co/KFBHvHY/frameme-logo.png" title="favicon">
    <title>Frame Me - Ny Användare</title>
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

            <form onsubmit="shopLib.register()" method="POST" class="register-form">

                <!-- Left side, delivery section -->
                <div class="checkout-form__container">
                    <section class="checkout-form__delivery-section">

                        <div class="err-tips"></div>

                        <h2 class="checkout-form__delivery-section__h2">Registrera ny användare</h2>

                        <label class="checkout-form__delivery-section__label" for="">e-post</label>
                        <input class="checkout-form__delivery-section__input" required id="email" type="email" name="email" placeholder="example@mail.com" maxlength=254>

                        <label class="checkout-form__delivery-section__label">lösenord - <span class="password-status">saknas</span></label>
                        <input class="checkout-form__delivery-section__input" required id="pass" type="password" name="pass" maxlength=20>

                        <label class="checkout-form__delivery-section__label">bekräfta lösenord - <span class="password-confirm-status">saknas</span></label>
                        <input class="checkout-form__delivery-section__input" required id="passconfirm" type="password" name="passconfirm" maxlength=20>

                        <label class="checkout-form__delivery-section__label" for="">Förnamn</label>
                        <input class="checkout-form__delivery-section__input" required id="fname" type="text" name="fname" minlenght=2 maxlength=20>

                        <label class="checkout-form__delivery-section__label" for="">Efternamn</label>
                        <input class="checkout-form__delivery-section__input" required id="lname" type="text" name="lname" minlenght=2 maxlength=20>

                        <label class="checkout-form__delivery-section__label" for="">Telefonnummer</label>
                        <input class="checkout-form__delivery-section__input" required id="tel" type="text" name="phone" placeholder="+46 or 07 pattern" maxlength=12>

                        <label class="checkout-form__delivery-section__label" for="">Gatuadress</label>
                        <input class="checkout-form__delivery-section__input" required id="adress" type="text" name="adress" placeholder="Gustafvägen 10D" maxlength=50>

                        <label class="checkout-form__delivery-section__label" for="">Postnummer</label>
                        <input class="checkout-form__delivery-section__input" required id="pcode" type="text" name="pcode" placeholder="123 45" maxlength=7>

                        <label class="checkout-form__delivery-section__label" for="">Ort</label>
                        <input class="checkout-form__delivery-section__input" required id="city" type="text" name="county" maxlength=50>

                        <button type="submit" class="checkout-form__delivery-section__deliveryBtn">Registrera ny användare</button>

                    </section>
                </div>

            </form>

        </div>

    </main>

    <?php require_once __DIR__ . '/php/view/footer.php';?>

    <!-- js scripts go here -->
    <?php require_once __DIR__ . '/php/view/jscore.php';?>

</body>

</html>