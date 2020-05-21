<?php

// only POST requests are allowed
if (strtoupper($_SERVER['REQUEST_METHOD']) != 'POST') {die;}

require_once __DIR__ . "/../controller/controller.php";
require_once __DIR__ . "/../model/utils.php";

$customerData = [
    "email" => trimSides($_POST['email']),
    "first_name" => trimSides($_POST['fname']),
    "last_name" => trimSides($_POST['lname']),
    "phone" => trimSides($_POST['phone']),
    "street" => trimSides($_POST['adress']),
    "postal_number" => trimSides($_POST['pcode']),
    "county" => trimSides($_POST['county']),
];

$password = $_POST['pass'];
