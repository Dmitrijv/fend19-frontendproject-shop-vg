<?php
session_start();
?>

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

            <form onsubmit="shopLib.registerNewUser(event)" method="POST" class="register-form">

                <!-- Left side, delivery section -->
                <div class="checkout-form__container">
                    <section class="checkout-form__delivery-section">

                        <h2 class="checkout-form__delivery-section__h2">Registrera ny användare</h2>

                        <label class="checkout-form__delivery-section__label" for="">E-post</label>
                        <input class="checkout-form__delivery-section__input" required id="email" type="email" name="email" placeholder="example@mail.com" maxlength=254>

                        <label class="checkout-form__delivery-section__label">Lösenord <span class="pass-status"></span></label>
                        <ul>
                            <li>minst 8 tecken totalt <span id="passLen"></span></li>
                            <li>minst 1 stor bokstav <span id="passUpper"></span></li>
                            <li>minst 1 liten bokstav <span id="passLower"></span></li>
                            <li>minst 1 siffra <span id="passDigit"></span></li>
                            <li>minst 1 special tecken (!-._@#$%^&*) <span id="passSpecial"></span></li>
                        </ul>
                        <input class="checkout-form__delivery-section__input" required id="pass" type="password" name="pass" minlenght=8 maxlength=20>

                        <label class="checkout-form__delivery-section__label">Bekräfta lösenordet <span class="passconfirm-status"></span></label>
                        <input class="checkout-form__delivery-section__input" required id="passconfirm" type="password" name="passconfirm" minlenght=8 maxlength=30>

                        <label class="checkout-form__delivery-section__label" for="">Förnamn</label>
                        <input class="checkout-form__delivery-section__input" required id="fname" type="text" name="fname" minlenght=1 maxlength=20>

                        <label class="checkout-form__delivery-section__label" for="">Efternamn</label>
                        <input class="checkout-form__delivery-section__input" required id="lname" type="text" name="lname" minlenght=1 maxlength=20>

                        <label class="checkout-form__delivery-section__label" for="">Telefonnummer</label>
                        <input class="checkout-form__delivery-section__input" required id="tel" type="text" name="phone" placeholder="073-111 22 33" pattern="0[0-9]{1,3}-?[0-9 ]{6,9}" minlength=8 maxlength=13>

                        <label class="checkout-form__delivery-section__label" for="">Gatuadress</label>
                        <input class="checkout-form__delivery-section__input" required id="adress" type="text" name="adress" placeholder="Gustafvägen 10D" maxlength=50>

                        <label class="checkout-form__delivery-section__label" for="">Postnummer</label>
                        <input class="checkout-form__delivery-section__input" required id="pcode" type="text" name="pcode" placeholder="123 45" maxlength=6 pattern="[0-9]{3,3} [0-9]{2,2}">

                        <label class="checkout-form__delivery-section__label" for="">Ort</label>
                        <input class="checkout-form__delivery-section__input" required id="city" type="text" name="county" placeholder="Stockholm" maxlength=50>

                        <button type="submit" class="checkout-form__delivery-section__deliveryBtn">Registrera ny användare</button>

                        <div id="register-form-error-msg" class="redText"></div>


                    </section>
                </div>

            </form>

        </div>

    </main>

    <?php require_once __DIR__ . '/php/view/footer.php';?>

    <!-- js scripts go here -->
    <?php require_once __DIR__ . '/php/view/jscore.php';?>
    <script type="text/javascript" src="./js/user/passwordValidator.js"></script>

</body>

</html>