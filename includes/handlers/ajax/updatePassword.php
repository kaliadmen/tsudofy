<?php
include("../../config.php");

if(!isset($_POST['username'])){
    echo "ERROR: Could not set username";
    exit();
}

if(!isset($_POST['oldPassword']) || !isset($_POST['newPassword']) || !isset($_POST['confirmedPassword'])) {
    echo "Not all Passwords have been set";
    exit();
}

if($_POST['oldPassword'] == "" || $_POST['newPassword'] == "" || $_POST['confirmedPassword'] == "") {
    echo "Please fill in all fields";
    exit();
}

$username = $_POST['username'];
$oldPassword = $_POST['oldPassword'];
$newPassword = $_POST['newPassword'];
$confirmPassword = $_POST['confirmedPassword'];
$oldPasswordQuery = mysqli_query($connection, "SELECT password FROM users WHERE username='{$username}'")->fetch_assoc()['password'];


if($oldPassword == $newPassword){
    echo "Password was not updated. Try using another new password";
    exit();
}

if(!password_verify($oldPassword, $oldPasswordQuery)){
    echo "Password is incorrect";
    exit();
}

if($newPassword != $confirmPassword){
    echo "Passwords do not match";
    exit();
}

if(preg_match('/[^A-Za-z0-9]/', $newPassword)){
    echo "Your password may only contain letters and numbers";
    exit();
}

if(strlen($newPassword) > 30|| strlen($newPassword) < 8){
    echo "Your password must be between 8 and 30 characters";
    exit();
}

$hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

$updatePasswordQuery = mysqli_query($connection, "UPDATE users SET password='{$hashedPassword}' WHERE username='{$username}'");

echo "Password updated successfully";