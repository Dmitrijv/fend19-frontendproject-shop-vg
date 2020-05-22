<?php

// only POST requests are allowed
if (strtoupper($_SERVER['REQUEST_METHOD']) != 'POST') {die;}

require_once __DIR__ . "/../controller.php";
require_once __DIR__ . "/../../model/utils.php";

$customerData = [
    "email" => trimSides($_POST['email']),
    "first_name" => trimSides($_POST['fname']),
    "last_name" => trimSides($_POST['lname']),
    "phone" => trimSides($_POST['phone']),
    "street" => trimSides($_POST['adress']),
    "postal_number" => trimSides($_POST['pcode']),
    "county" => trimSides($_POST['county']),
];

$customerDataId = md5(
    $customerData['email'] .
    $customerData['first_name'] .
    $customerData['first_name'] .
    $customerData['last_name'] .
    $customerData['phone'] .
    $customerData['street'] .
    $customerData['postal_number'] .
    $customerData['county']
);

// save customer data if it doesn't already exist in db
if (doesCustomerDataIdExist($customerDataId) == false) {
    saveCustomerDataToDb($customerDataId, $customerData);
}

$password = $_POST['pass'];

$newUser = [
    "password" => password_hash($password, PASSWORD_DEFAULT),
    "customer_data_id" => $customerDataId,
];

createNewUser($newUser);
die;
