<?php
    include ("includes/config.php");
    include("includes/classes/Account.php");
    include("includes/classes/Constants.php");

    $account = new Account($connection);

    include("includes/handlers/register_handler.php");
    include("includes/handlers/login_handler.php");

    function getInputValue(string $name) : void {
        if(isset($_POST[$name])){
            echo $_POST[$name];
        }
    }
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Welcome to Tsudo Stream</title>
</head>
<body>
    <div id="input-container">
        <form id="login-form" action="" method="POST">
            <h2>Login to your account</h2>
            <p>
                <?php echo $account->getError(Constants::$loginFailed); ?>
                <label for="username-login">Username</label>
                <input id="username-login" name="username-login" type="text" placeholder="Enter your username" required>
            </p>
            <p>
                <label for="password-login">Password</label>
                <input id="password-login" name="password-login" type="password" required>
            </p>
            <button type="submit" name="login-button">LOGIN</button>
        </form>

        <form id="register-form" action="" method="POST">
            <h2>Create your free account</h2>
            <p>
                <?php echo $account->getError(Constants::$usernameNotCorrectLength); ?>
                <?php echo $account->getError(Constants::$usernameTaken); ?>
                <label for="username-register">Username</label>
                <input id="username-register" name="username-register" type="text" placeholder="Enter a username" value="<?php getInputValue('username') ?>" required>
            </p>
            <p>
                <?php echo $account->getError(Constants::$firstNameNotCorrectLength); ?>
                <label for="first-name">First name</label>
                <input id="first-name" name="first-name" type="text" placeholder="Enter your first name" value="<?php getInputValue('first-name') ?>" required>
            </p>
            <p>
                <?php echo $account->getError(Constants::$lastNameNotCorrectLength); ?>
                <label for="last-name">Last name</label>
                <input id="last-name" name="last-name" type="text" placeholder="Enter your last name" value="<?php getInputValue('last-name') ?>" required>
            </p>
            <p>
                <?php echo $account->getError(Constants::$emailDoesNotMatch); ?>
                <?php echo $account->getError(Constants::$emailNotValid); ?>
                <?php echo $account->getError(Constants::$emailUsed); ?>
                <label for="email">Email</label>
                <input id="email" name="email" type="email" placeholder="Enter your email" value="<?php getInputValue('email') ?>" required>
            </p>
            <p>
                <label for="email-confirm">Confirm email</label>
                <input id="email-confirm" name="email-confirm" type="email" placeholder="Reenter you email" value="<?php getInputValue('email-confirm') ?>" required>
            </p>
            <p>
                <?php echo $account->getError(Constants::$passwordsDoNotMatch); ?>
                <?php echo $account->getError(Constants::$passwordNotCorrectLength); ?>
                <?php echo $account->getError(Constants::$passwordHasInvalidCharacters); ?>
                <label for="password">Password</label>
                <input id="password" name="password" type="password" required>
            </p>
            <p>
                <label for="password-confirm">Confirm password</label>
                <input id="password-confirm" name="password-confirm" type="password" required>
            </p>

            <button type="submit" name="register-button">SIGN UP</button>
        </form>
    </div>
</body>
</html>