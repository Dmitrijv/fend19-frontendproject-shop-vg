<?php

session_start(); // start session
session_unset(); // remove all session variables
session_destroy(); // destroy the session

header("Location: index.php");
die;
