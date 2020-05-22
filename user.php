<?php
session_start();

if (!isset($_SESSION['userData'])) {
    header("Location: login.php");
    die;
}

$customerData = $_SESSION['userData'];

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
        <div class="content user-content">

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
            </section>
            <section class="user-history"></section>

        </div>
    </main>

    <?php require_once __DIR__ . '/php/view/footer.php';?>

    <!-- js scripts go here -->
    <?php require_once __DIR__ . '/php/view/jscore.php';?>

</body>

</html>