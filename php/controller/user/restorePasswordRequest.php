<?php

require_once __DIR__ . "/../controller.php";
require_once __DIR__ . "/../../model/utils.php";

// only POST requests are allowed
if (strtoupper($_SERVER['REQUEST_METHOD']) != 'POST') {
    http_response_code(400);
    die;
}

// email fields is empty
if (!isset($_POST['email'])) {
    http_response_code(400);
    die;
}

$email = $_POST['email'];

if (!isEmailRegistered($email)) {
    http_response_code(400);
    die;
}

$user_id = getUserIdByEmail($email);
$newPassword = generateRandomPassword(16);

$to = $email;
$subject = "FrameMe - Återställning av lösenordet.";
$message = 'Hej!</br></br>Nya lösenordet är <b>' . $newPassword . '</b></br></br>Vänliga Hälsningar</br>FramMe Support';
$header = "From:frameme@noreply.se \r\n";
$header .= "Cc:framemesupport@noreply.se \r\n";
$header .= "MIME-Version: 1.0\r\n";
$header .= "Content-type: text/html\r\n";

$mailSent = mail($to, $subject, $message, $header);
if (!$mailSent) {
    http_response_code(406);
    die;
}

$hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
setUserPassword($user_id, $hashedPassword);
die;
