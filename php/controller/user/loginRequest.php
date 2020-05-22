<?php

require_once __DIR__ . "/../controller.php";
require_once __DIR__ . "/../../model/utils.php";

// only POST requests are allowed
if (strtoupper($_SERVER['REQUEST_METHOD']) != 'POST') {
    http_response_code(400);
    die;
}

// email or password fields are empty
if (!isset($_POST['email']) || !isset($_POST['pass'])) {
    http_response_code(400);
    die;
}

$email = $_POST['email'];

// no user with this email exists
if (isEmailRegistered($email) == false) {
    http_response_code(400);
    die;
}

$password = $_POST['pass'];

// password doesn't match
if (!isCorrectPassword($password, $email)) {
    http_response_code(400);
    die;
}

session_start();
$_SESSION["userData"] = getCustomerDataByUserEmail($email);
die;
