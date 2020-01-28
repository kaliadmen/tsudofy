<?php
include("../../config.php");

if(isset($_POST['trackId'])){
    $trackId = $_POST['trackId'];

    $query = mysqli_query($connection, "UPDATE songs SET play_count = play_count + 1 WHERE id='{$trackId}'");
}