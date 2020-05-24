<?php

// only POST requests are allowed
if (strtoupper($_SERVER['REQUEST_METHOD']) != 'POST') {
    http_response_code(400);
    die;
}

require_once __DIR__ . "/../controller.php";
require_once __DIR__ . "/../../model/utils.php";

session_start();

$customerData = [
    "email" => trimSides($_POST['email']),
    "first_name" => trimSides($_POST['fname']),
    "last_name" => trimSides($_POST['lname']),
    "phone" => trimSides($_POST['phone']),
    "street" => trimSides($_POST['adress']),
    "postal_number" => trimSides($_POST['pcode']),
    "county" => trimSides($_POST['county']),
];

// doublecheck form input validity in case front-end validation failed
if (
    !isValidFormInputString($customerData['email']) ||
    !isValidFormInputString($customerData['first_name']) ||
    !isValidFormInputString($customerData['last_name']) ||
    !isValidFormInputString($customerData['phone']) ||
    !isValidFormInputString($customerData['street']) ||
    !isValidFormInputString($customerData['postal_number']) ||
    !isValidFormInputString($customerData['county'])
) {
    http_response_code(400);
    die;
}

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

$user_id = getUserIdByEmail($customerData['email']);
setCustomerDataId($user_id, $customerDataId);
$_SESSION["userData"] = getCustomerDataByUserEmail($customerData['email']);
die;
