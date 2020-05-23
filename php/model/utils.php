<?php

function trimSides($string)
{
    $string = ltrim($string);
    $string = rtrim($string);
    return $string;
}

function isValidFormInputString($string)
{
    // string consists of spaces or nullbyte characters
    if (trim($string) == '') {return false;}
    // string contains special characters
    if (strpos($string, '<') !== false) {return false;}
    if (strpos($string, '>') !== false) {return false;}
    if (strpos($string, '*') !== false) {return false;}
    if (strpos($string, '?') !== false) {return false;}
    if (strpos($string, '|') !== false) {return false;}
    if (strpos($string, ':') !== false) {return false;}
    if (strpos($string, '=') !== false) {return false;}
    if (strpos($string, '/') !== false) {return false;}
    if (strpos($string, '\/') !== false) {return false;}
    return true;
}

function generateRandomPassword($length)
{
    $length = ($length >= 16) ? $length : 16;

    $uletters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $lletters = 'abcdefghijklmnopqrstuvwxyz';
    $numbers = '0123456789';
    $characters = '!-._@#$%^&*';

    $randomString = '';
    for ($i = 0; $i < 5; $i++) {$randomString .= $uletters[rand(0, strlen($uletters) - 1)];}
    for ($i = 0; $i < 5; $i++) {$randomString .= $lletters[rand(0, strlen($lletters) - 1)];}
    for ($i = 0; $i < 3; $i++) {$randomString .= $numbers[rand(0, strlen($numbers) - 1)];}
    for ($i = 0; $i < 3; $i++) {$randomString .= $characters[rand(0, strlen($characters) - 1)];}

    return str_shuffle($randomString);
}
