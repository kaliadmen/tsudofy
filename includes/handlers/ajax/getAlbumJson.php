<?php
include("../../config.php");

if(isset($_POST['albumId'])){
    $albumId = $_POST['albumId'];

    $query = mysqli_query($connection, "SELECT id, artwork_path FROM albums WHERE id='{$albumId}'");
    $resultArray = mysqli_fetch_array($query);

    echo json_encode($resultArray);
}