# Webshop - Customer Record System

![preview](/readme/framemePreview.png)

The purpose of this task is to extend the Webshop project with a customer record system that lets you register a new account, manage user details, order products without having to fill in a delivery form (if you are logged in), see your order history and restore your password. The system is written in PHP, JavaScript and uses a MySQL database to persist data.

### Password validation

![preview](/readme/password-tips.gif)

I use Regex expressions to validate the passwords and also to identify which parts of the password format are followed so far.

```js
    isStrongPassword: function(string) {
        const passwordRegex = new RegExp(
        "^(((?=.*[a-z])(?=.*[A-Z]))((?=.*[A-Z])(?=.*[0-9])))(?=.*[!-._@#$%^&*]{1,})(?=.{10,})"
        );
        return passwordRegex.test(string);
    },
```

### Resetting the password

A user can choose to generate a new account password if he or she forgot the old one. If a valid registered email is provided a new password is generated with PHP.

The new password contains at least 16 characters and confirms to the same rules as when creating a password for a new account.
The new password is sent to the user via automated email. If the process of sending the email fails then the old password is not updated.

```php
    $user_id = getUserIdByEmail($email);
    $newPassword = generateRandomPassword(16);
    // message details and header are set here
    $mailSent = mail($to, $subject, $message, $header);
    if (!$mailSent) {
        http_response_code(406);
        die;
    }
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    setUserPassword($user_id, $hashedPassword);
    die;
```

The new password contains at least 16 characters and conforms to the same rules as when creating a password for a new account.

```php
function generateRandomPassword($length)
{
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
```

### Restricting pages

If a user attempts to access a page that he should not have access to he is redirected to an error page. This check is performed at the very beginning of any page that displays content based on a GET or a POST variable.

Basic request validity check on invoice.php page:

```php
// invalid request
if (
    !isset($_SESSION['userData'])
    || !isset($_SESSION['userData']['user_id'])
    || !isset($_GET['orderId'])
    || !is_numeric($_GET['orderId'])
    || !isset($_GET['orderStatus'])
    || !is_numeric($_GET['orderStatus'])
) {
    header("Location: error.php?errorMessage=Kunde inte visa fakturan.</br>Detta kan bero på att ordern inte finns eller att du inte har rättigheter att se ordern.</br>Logga in på kontot som ordern tillhör och försök igen.");
    die;
}
```

Supplimental privilege check:

```php
// requesting restricted information
$isEligible = isset($order) && (intval($_SESSION['userData']['user_id']) == $order['user_id'] || $_SESSION['userData']['user_id'] == $order['customer_data_id']);
if (!$isEligible) {
    header("Location: error.php?errorMessage=Kunde inte visa fakturan.</br>Detta kan bero på att ordern inte finns eller att du inte har rättigheter att se ordern.</br>Logga in på kontot som ordern tillhör och försök igen.");
    die;
}
```
