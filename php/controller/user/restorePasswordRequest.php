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
$isRegistered = isEmailRegistered($email);

if (!$isRegistered) {
    http_response_code(400);
    die;
}

$user_id = getUserIdByEmail($email);
$newPassword = generateRandomPassword(16);
$hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

$to = $email;
$subject = "FrameMe - Återställning av löseordet.";
$message = 'Hej!</br> Ditt nya lösenord är <b>' . $newPassword . '</b></br></br>Vänliga Hälsningar</br></br>FramMe Support';
$header = "From:frameme@noreply.se \r\n";
$header .= "Cc:framemesupport@noreply.se \r\n";
$header .= "MIME-Version: 1.0\r\n";
$header .= "Content-type: text/html\r\n";

$mailSent = mail($to, $subject, $message, $header);

if (!$mailSent) {
    http_response_code(406);
    die;
}

setUserPassword($user_id, $hashedPassword);
die;
