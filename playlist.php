<?php
include("./includes/includedFiles.php");

if(isset($_GET['id'])){
    $playlistId = $_GET['id'];
}
else{
    header("Location: index.php");
}

$playlist = new Playlist($connection, $playlistId);
$owner = new User($connection, $playlist->getOwner());

function makePlural($item){
    if($item > 1){
        echo 's';
    }
}

?>
<div class="entity-info">
    <div class="left-section">
        <div class="playlist-image">
            <img  src='./assets/images/icons/playlist.png' alt='Playlist Image'>
        </div>
    </div>
    <div class="right-section">
        <h2><?php echo $playlist->getName();?></h2>
        <p>By <?php echo $playlist->getOwner();?></p>
        <p><?php echo $playlist->getNumberOfSongs();?> Song<?php makePlural($playlist->getNumberOfSongs());?></p>
        <button class="button delete" onclick="deletePlaylist(<?php echo  $playlistId;?>)">DELETE PLAYLIST</button>
    </div>
</div>
<div class="tracklist-container">
    <ul class="tracklist">
        <?php
        $songIdArray = $playlist->getSongIds();
        $index = 1;

        foreach($songIdArray as $songId){
            $playlistSong = new Song($connection, $songId);
            $songArtist = $playlistSong->getArtist();

            echo"<li class='tracklist-row'>
                        <div class='track-count'>
                            <img src='./assets/images/icons/play-white.png' alt='Play' class='play' onclick='setTrack(\"".$playlistSong->getId()."\", tempPlaylist, true)'>
                            <span class='track-number'>$index</span>
                        </div>
                        <div class='track-info'>
                            <span class='track-name'>".$playlistSong->getTitle()."</span>
                            <span class='artist-name'>".$songArtist->getName()."</span>
                        </div>
                        <div class='track-options'>
                        <input type='hidden' class='song-id' value='". $playlistSong->getId() ."'>
                            <img src='./assets/images/icons/more.png' alt='Options' class='options-button' onclick='showOptionsMenu(this)'>
                        </div>
                        <div class='track-duration'>
                            <span class='duration'>".$playlistSong->getDuration()."</span>
                        </div>                        
                    </li>";

            $index++;
        }
        ?>
        <script>
            var tempSongIds = '<?php echo json_encode($songIdArray);?>';
            tempPlaylist = JSON.parse(tempSongIds);
        </script>
    </ul>
</div>

<nav class="options-menu">
    <input type="hidden" class="song-id">
    <?php echo Playlist::getPlaylistDropdown($connection, $loggedInUser->getUsername()); ?>
    <div class="item" onclick="deleteFromPlaylist(this, '<?php echo $playlistId?>')">Remove from playlist</div>
</nav>