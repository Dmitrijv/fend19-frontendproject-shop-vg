<?php 
$name =""; //Senders name
$email =""; //Senders email
$phone =""; //Senders phone 
$message =""; //Senders message
$nameError = $emailError = $phoneError = $messageError ="";


if(isset($_POST['submit'])){

    if(empty($_POST['name'])) {
        $nameError = "Namn är obligatoriskt";
    } else {
        $name = test_input($_POST["name"]); // check name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/",$name))
        {
        $nameError = "Bara bokstäver och mellanslag är tillåtna";
        }
    }

    if (empty($_POST["email"])) {
        $emailError = "Email är obligatoriskt";
    } else {
        $email = test_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailError = "Ogiltig E-post adress";
        }
    }


    //NOT WORKING TO FULL EXTENT 
    if (empty($_POST["phone"])) {
        $phoneError = "Telefon är obligatoriskt";
    } else {
        $phone = test_input($_POST["phone"]);
        // $validPhone = validationPhone($phone);
        // echo $validPhone;
        // ('/^(\d[\s-]?)?[\(\[\s-]{0,2}?\d{3}[\)\]\s-]{0,2}?\d{3}[\s-]?\d{4}$/i'), '/^[0-9]{10}+$/'
        if(!preg_match('/^(\d[\s-]?)?[\(\[\s-]{0,2}?\d{3}[\)\]\s-]{0,2}?\d{3}[\s-]?\d{4}$/i', $phone)) {
            $phoneError = "Ogiltigt telefonnummer";
        }
    }

    if (empty($_POST["msg"])) {
        $messageError = "Meddelande är obligatoriskt";
    } else {
        $message = test_input($_POST["msg"]);
    }

    if ($nameError == '' && $emailError == '' && $phoneError == '' &&$messageError == '' ) {
        echo "hej";
    }

}


function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function validationPhone($phone) {
    
    if(preg_match('/^[0-9]{10}+$/', $phone)) {
        $phoneError = "Valid phone";
    } else{
        $phoneError = "Invalid phone";
    }
        
//     $valid_number = filter_var($phone, FILTER_SANITIZE_NUMBER_INT);
//     echo $valid_number;
}
?>