<?php
include "includes/includedFiles.php";

?>

<div class="playlist-container">
    <div class="grid-view-container">
        <h2>PLAYLISTS</h2>
        <div class="button-items">
            <button class="button green" onclick="createPlaylist()">
                NEW PLAYLIST
            </button>
        </div>

        <?php
        $username = $loggedInUser->getUsername();

        $playlistQuery = mysqli_query($connection, "SELECT * FROM playlists WHERE owner='{$username}'");

        if(mysqli_num_rows($playlistQuery) == 0) {
            echo "<span class='no-results'>You dont have any  playlist yet.</span>";
        }

        while($row = mysqli_fetch_array($playlistQuery)){
            $playlist = new Playlist($connection, $row);

            echo "<div class='grid-view-item' role='link' tabindex='0' 
            onclick='openPage(\"playlist.php?id=".$playlist->getId()."\")'>
                    <div class='playlist-image'>
                        <img src='./assets/images/icons/playlist.png' alt='Playlist Image'>
                    </div>
                    <div class='grid-view-info'>".$playlist->getName()."</div>
                  </div>";
        }

        ?>
    </div>
</div>
