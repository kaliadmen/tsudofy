<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
        include ("includes/config.php");
        //Artist class must be included before Album class. The Album class returns an Artist is some functions
        include("includes/classes/Artist.php");
        include("includes/classes/Album.php");
        include("includes/classes/Song.php");
        if(isset($_SESSION['userLoggedIn'])){
            $userLoggedIn = $_SESSION['userLoggedIn'];
            echo "<script>loggedInUser = '".$userLoggedIn."';</script>";
        } else{
            header("Location: register.php");
        }

    }else{
        include("includes/header.php");
        include("includes/footer.php");

        if(isset($_SESSION['userLoggedIn'])){
            $userLoggedIn = $_SESSION['userLoggedIn'];
            echo "<script>loggedInUser = '".$userLoggedIn."';</script>";
        } else{
            header("Location: register.php");
        }

        $url = $_SERVER['REQUEST_URI'];
        echo "<script> openPage('$url');</script>";
        exit();
    }
?>