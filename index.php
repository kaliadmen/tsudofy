<?php

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
                <label for="username-login">Username</label>
                <input id="username-login" name="username-login" type="text" placeholder="Enter your username" required>
            </p>
            <p>
                <label for="password-login">Password</label>
                <input id="password-login" name="password-login" type="password" required>
            </p>
            <button type="submit" name="login-button">LOGIN</button>
        </form>

        <form id="register-form" action=""method="POST">
            <h2>Create your free account</h2>
            <p>
                <label for="username-register">Username</label>
                <input id="username-register" name="username-register" type="text" placeholder="Enter a username" required>
            </p>
            <p>
                <label for="first-name">First name</label>
                <input id="first-name" name="first-name" type="text" placeholder="Enter your first name" required>
            </p>
            <p>
                <label for="last-name">Last name</label>
                <input id="last-name" name="last-name" type="text" placeholder="Enter your last name" required>
            </p>
            <p>
                <label for="email">Email</label>
                <input id="email" name="email" type="email" placeholder="Enter your email" required>
            </p>
            <p>
                <label for="email-confirm">Confirm email</label>
                <input id="email-confirm" name="email-confirm" type="email" placeholder="Reenter you email" required>
            </p>
            <p>
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