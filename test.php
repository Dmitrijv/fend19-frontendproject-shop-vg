<?php

require_once __DIR__ . "/php/controller/controller.php";

session_start();

// var_dump($_SESSION['userData']);
// var_dump($_SESSION['test']);
var_dump($_SESSION);

// var_dump(getCustomerDataByUserEmail("dmitrij.vel@live.se"));

// session_unset(); // remove all session variables
// session_destroy(); // destroy the session

// header("Location: index.php");
die;
