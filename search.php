<?php
    include("includes/includedFiles.php");

    if(isset($_GET['term'])){
        $term = urldecode($_GET['term']);
    }
    else{
        $term = "";
    }

?>

<div class="search-container">
    <h4>Search for an album, artist, or song</h4>
    <label for=""></label>
    <input type="text" class="search-input"value="<?php echo $term;?>" onfocus="this.selectionStart = this.selectionEnd = this.value.length" placeholder="Start typing...">
</div>

<script>
    $(".search-input").focus();

    $(function() {
        $(".search-input").keyup(function(){
            clearTimeout(timer);

            timer = setTimeout(function() {
                let val = $(".search-input").val();
                openPage("search.php?term=" + val);
            }, 700);
        });
    })
</script>

<?php if($term == "") exit(); ?>

<div class="tracklist-container border-bottom">
    <h2>SONGS</h2>
    <ul class="tracklist">

        <?php
        $trackQuery = mysqli_query($connection, "SELECT id FROM songs WHERE title LIKE '{$term}%' LIMIT 10");

        if(mysqli_num_rows($trackQuery) == 0) {
            echo "<span class='no-results'>No songs found matching " . $term . "</span>";
        }



        $songIdArray = array();

        $index = 1;
        while($row = mysqli_fetch_array($trackQuery)) {

            if($index > 15) {
                break;
            }

            array_push($songIdArray, $row['id']);

            $albumSong = new Song($connection, $row['id']);
            $albumArtist = $albumSong->getArtist();

            echo "<li class='tracklist-row'>
					<div class='track-count'>
						<img class='play' src='assets/images/icons/play-white.png' onclick='setTrack(\"" . $albumSong->getId() . "\", tempPlaylist, true)'>
						<span class='track-number'>$index</span>
					</div>


					<div class='track-info'>
						<span class='track-name'>" . $albumSong->getTitle() . "</span>
						<span class='artist-name'>" . $albumArtist->getName() . "</span>
					</div>

					<div class='track-options'>
                        <input type='hidden' class='song-id' value='". $albumSong->getId() ."'>
                            <img src='./assets/images/icons/more.png' alt='Options' class='options-button' onclick='showOptionsMenu(this)'>
                        </div>

					<div class='track-duration'>
						<span class='duration'>" . $albumSong->getDuration() . "</span>
					</div>


				</li>";

            $index++;
        }

        ?>

        <script>
            var tempSongIds = '<?php echo json_encode($songIdArray); ?>';
            tempPlaylist = JSON.parse(tempSongIds);
        </script>

    </ul>
</div>

<nav class="options-menu">
    <input type="hidden" class="song-id">
    <?php echo Playlist::getPlaylistDropdown($connection, $loggedInUser->getUsername()); ?>
    <div class="item">Copy song link</div>
</nav>

<div class="artist-container border-bottom">
    <h2>Artist</h2>
    <?php
        $artistQuery = mysqli_query($connection, "SELECT id FROM artists WHERE name LIKE '{$term}%' LIMIT 10");

        if(mysqli_num_rows($artistQuery) == 0) {
            echo "<span class='no-results'>No artists found matching " . $term . "</span>";
        }

        while($row = mysqli_fetch_array($artistQuery)){
            $artistFound = new Artist($connection, $row['id']);

            echo "<div class='search-results-row'>
                    <div class='artist-name'>
                        <span role='link' tabindex='0' onclick='openPage(\"artist.php?id=".$artistFound->getId()."\")'>
                        ".$artistFound->getName()."
                        </span>
                    </div>
                  </div>";
        }

    ?>
</div>
<div class="grid-view-container">
    <h2>ALBUMS</h2>
    <?php
    $albumQuery = mysqli_query($connection, "SELECT * FROM albums WHERE title LIKE '{$term}%'");

    if(mysqli_num_rows($albumQuery) == 0) {
        echo "<span class='no-results'>No albums found matching " . $term . "</span>";
    }

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