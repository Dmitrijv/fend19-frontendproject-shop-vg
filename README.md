# Webshop - Customer Record System

![preview](/readme/framemePreview.png)

The purpose of this task is to extend the Webshop project with a customer record system that lets you register a new account, manage user details, order products without having to fill in a delivery form (if you are logged in), see your order history and restore your password. The system is written in PHP, JavaScript and uses a MySQL database to persist data.

## Registering a new user

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
