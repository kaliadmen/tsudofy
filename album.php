<?php
    include("./includes/header.php");

    if(isset($_GET['id'])){
        $albumId = $_GET['id'];
    }
    else{
       header("Location: index.php");
    }

    $album = new Album($connection, $albumId);
    $artist = $album->getArtist();

    function makePlural($item){
        if($item > 1){
            echo 's';
        }
    }
?>
<div class="entity-info">
    <div class="left-section">
        <img src="<?php echo $album->getArtworkPath();?>" class="" alt="Album Artwork">
    </div>
    <div class="right-section">
        <h2><?php echo $album->getTitle();?></h2>
        <p>By <?php echo $artist->getName();?></p>
        <p><?php echo $album->getNumberOfSongs();?> Song<?php makePlural($album->getNumberOfSongs());?></p>
    </div>
</div>
<div class="tracklist-container">
    <ul class="tracklist">
        <?php
            $songIdArray = $album->getSongIds();
            $index = 1;

            foreach($songIdArray as $songId){
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
                            <img src='./assets/images/icons/more.png' alt='Options' class='options-button'>
                        </div>
                        <div class='track-duration'>
                            <span class='duration'>".$albumSong->getDuration()."</span>
                        </div>                        
                    </li>";

                $index++;
            }
        ?>
        <script>
            let tempSongIds = '<?php echo json_encode($songIdArray);?>';
            tempPlaylist = JSON.parse(tempSongIds);
        </script>
    </ul>
</div>


<?php include("./includes/footer.php");?>

