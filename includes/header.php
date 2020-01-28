<?php
    include ("includes/config.php");
    //Artist class must be included before Album class. The Album class returns an Artist is some functions
    include("includes/classes/Artist.php");
    include("includes/classes/Album.php");
    include("includes/classes/Song.php");

    if(isset($_SESSION['userLoggedIn'])){
        $userLoggedIn = $_SESSION['userLoggedIn'];
    } else{
        header("Location: register.php");
    }

?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        <script src="../assets/js/script.js"></script>
        <link rel="stylesheet" href="assets/css/style.css">
        <title>Tsudo Stream</title>
        <link rel="shortcut icon" href="favicon.ico" />
    </head>
    <body>
    <div id="main-container">
        <div id="top-container">
            <?php include("./includes/navbar.php");?>
            <div id="main-view-container">
                <div id="main-content">