<?php
include("../../config.php");

if(isset($_POST['playlistId']) && isset($_POST['songId'])){
    $playlistId = $_POST['playlistId'];
    $songId = $_POST['songId'];

    $query = mysqli_query($connection, "DELETE FROM playlist_songs WHERE playlist_id='{$playlistId}' AND song_id='{$songId}'");

}else{
    echo "Playlist id or song id parameter not passed into file";
}