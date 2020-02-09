<?php
    include("includes/includedFiles.php");

    if(isset($_GET['id'])){
        $artistId = $_GET['id'];
    }
    else{
        header("Location: index.php");
    }

    $artist = new Artist($connection, $artistId);
?>

<div class="entity-info border-bottom">
    <div class="center-section">
        <div class="artist-info">
            <h1 class="artist-name"><?php echo $artist->getName(); ?></h1>
            <div class="header-button">
                <button class="button green" onclick="playFirstSong()">PLAY</button>
            </div>
        </div>
    </div>

</div>
<div class="tracklist-container border-bottom">
    <h2>SONGS</h2>
    <ul class="tracklist">
        <?php
        $songIdArray = $artist->getSongIds();
        $index = 1;

        foreach($songIdArray as $songId){
            if($index > 5){
                break;
            }
            $albumSong = new Song($connection, $songId);
            $albumArtist = $albumSong->getArtist();

            echo"<li class='tracklist-row'>
                        <div class='track-count'>
                            <img src='./assets/images/icons/play-white.png' alt='Play' class='play' onclick='setTrack(\"".$albumSong->getId()."\", tempPlaylist, true)'>
                            <span class='track-number'>$index</span>
                        </div>
                        <div class='track-info'>
                            <span class='track-name'>".$albumSong->getTitle()."</span>
                            <span class='artist-name'>".$albumArtist->getName()."</span>
                        </div>
                        <div class='track-options'>
                        <input type='hidden' class='song-id' value='". $albumSong->getId() ."'>
                            <img src='./assets/images/icons/more.png' alt='Options' class='options-button' onclick='showOptionsMenu(this)'>
                        </div>
                        <div class='track-duration'>
                            <span class='duration'>".$albumSong->getDuration()."</span>
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
    <div class="item">Copy song link</div>
</nav>

<div class="grid-view-container">
    <h2>ALBUMS</h2>
    <?php
    $albumQuery = mysqli_query($connection, "SELECT * FROM albums WHERE artist='{$artistId}'");

    while($row = mysqli_fetch_array($albumQuery)){
        echo "<div class='grid-view-item'>
                        <span role='link' tabindex='0' onclick='openPage(\"album.php?id=".$row['id']."\")'>
                            <img src='".$row['artwork_path']."' alt='Album art'>
                            <div class='grid-view-info'>".$row['title']."</div>
                        </span>
                      </div>";
    }
    ?>
</div>
