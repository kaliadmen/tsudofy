<?php
function sanitizeLoginString(string $inputText) : string {
    $inputText = strip_tags($inputText);
    $inputText = str_replace(" ", "", $inputText);
    return $inputText;
}

if(isset($_POST['login-button'])){
    $username = sanitizeLoginString($_POST['username-login']);
    $password = sanitizeFormPassword($_POST['password-login']);

    $wasSuccessful = $account->login($username, $password);

    if($wasSuccessful){
        $_SESSION['userLoggedIn'] = $username;
        header("Location: index.php");
    }
}