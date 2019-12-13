<?php
function sanitizeFormUsername(string $inputText) : string {
    $inputText = strip_tags($inputText);
    $inputText = str_replace(" ", "", $inputText);
    return $inputText;
}

function sanitizeFormString(string $inputText) : string {
    $inputText = strip_tags($inputText);
    $inputText = str_replace(" ", "", $inputText);
    $inputText = ucfirst(strtolower($inputText));
    return $inputText;
}

function sanitizeFormPassword(string $inputText) : string {
    $inputText = strip_tags($inputText);
    return $inputText;
}

if(isset($_POST['register-button'])){
    $username = sanitizeFormUsername($_POST['username-register']);
    $firstName = sanitizeFormString($_POST['first-name']);
    $lastName = sanitizeFormString($_POST['last-name']);
    $email = sanitizeFormString($_POST['email']);
    $confirmedEmail = sanitizeFormString($_POST['email-confirm']);
    $password = sanitizeFormPassword($_POST['password']);
    $confirmedPassword = sanitizeFormPassword($_POST['password-confirm']);

    $wasSuccessful = $account->register($username, $firstName, $lastName, $email, $confirmedEmail, $password, $confirmedPassword);

    if($wasSuccessful){
        $_SESSION['userLoggedIn'] = $username;
        header("Location: index.php");
    }
}
?>