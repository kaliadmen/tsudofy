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
            <button type="submit" name="login-button">Login</button>
        </form>
    </div>
</body>
</html>