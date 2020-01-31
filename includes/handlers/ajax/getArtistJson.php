<?php
include("../../config.php");

if(isset($_POST['artistId'])){
    $artistID = $_POST['artistId'];

    $query = mysqli_query($connection, "SELECT * FROM artists WHERE id='{$artistID}'");
    $resultArray = mysqli_fetch_array($query);

    echo json_encode($resultArray);
}