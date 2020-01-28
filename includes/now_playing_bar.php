<?php
    //Create a random playlist
    $songQuery = mysqli_query($connection, "SELECT id FROM songs ORDER BY RAND() LIMIT 10");
    $resultArray = array();

    while($row = mysqli_fetch_array($songQuery)){
        array_push($resultArray, $row['id']);
    }

    $jsonArray = json_encode($resultArray);
    ?>

<script>
   $(document).ready(function() {
       let newPlaylist = <?php echo $jsonArray;?>;
       audioElement = new Audio();
       setTrack(newPlaylist[0], newPlaylist, false);
       updateVolumeProgressBar(audioElement.audio);

       $("#now-playing-bar-container").on("mousedown touchstart mousemove touchmove", function(e) {
            e.preventDefault();
       });

       $(".playback-bar .progress-bar").mousedown(function() {
            mouseDown = true;
        });

       // mouse click object passed as e
       $(".playback-bar .progress-bar").mousemove(function(e) {
           if(mouseDown){
               timeFromOffset(e, this);
           }
       });

       $(".playback-bar .progress-bar").mouseup(function(e) {
           timeFromOffset(e, this);
       });

       $(".playback-bar .progress-bar").mouseup(function(e) {
           mouseDown = false;
       });

       $(".volume-bar .progress-bar").mousedown(function() {
           mouseDown = true;
       });

       $(".volume-bar .progress-bar").mousemove(function(e) {
           if(mouseDown){
               let percentage = e.offsetX / $(this).width();

               if(percentage >= 0 && percentage <= 1){
                   audioElement.audio.volume = percentage;
               }
           }
       });

       $(".volume-bar .progress-bar").mouseup(function(e) {
           let percentage = e.offsetX / $(this).width();

           if(percentage >= 0 && percentage <= 1){
               audioElement.audio.volume = percentage;
           }
       });

       $(".volume-bar .progress-bar").mouseup(function(e) {
           mouseDown = false;
       });
   });

   function setTrack(trackId, newPlaylist, play){
       if(newPlaylist !== currentPlaylist){
           currentPlaylist = newPlaylist;
           //make a copy of current playlist
           shufflePlaylist = currentPlaylist.slice();
           shuffleArray(shufflePlaylist);
       }

       if(shuffle === true){
           currentPlaylistIndex = shufflePlaylist.indexOf(trackId);
       }else{
           currentPlaylistIndex = currentPlaylist.indexOf(trackId);
       }

       pauseSong();

         $.post("./includes/handlers/ajax/getSongJson.php", {trackId: trackId}, function(data) {
             let track = JSON.parse(data);

             $(".track-name span").text(track.title);

             $.post("./includes/handlers/ajax/getArtistJson.php", {artistId: track.artist}, function(data) {
                 let artist = JSON.parse(data);

                 $(".artist-name span").text(artist.name);
             });

             $.post("./includes/handlers/ajax/getAlbumJson.php", {albumId: track.album}, function(data) {
                 let album = JSON.parse(data);

                 $(".album-link img").attr("src", album.artwork_path);
             });

             audioElement.setTrack(track);
             playSong();
         });

         if(play === true) {
             audioElement.play();
         }
   }

   function playSong(){
       if(audioElement.audio.currentTime === 0){
           $.post("./includes/handlers/ajax/updatePlayCount.php", {trackId: audioElement.currentPlaying.id});
       }

       $(".control-button.play").hide();
       $(".control-button.pause").show();
       audioElement.play();
   }

   function pauseSong() {
       $(".control-button.play").show();
       $(".control-button.pause").hide();
        audioElement.pause();
   }
   
   function nextSong() {
       if(repeat === true){
           audioElement.setTime(0);
           playSong();
           return;
       }
       if(currentPlaylistIndex === currentPlaylist.length - 1){
           currentPlaylistIndex = 0;
       }else{
           currentPlaylistIndex++;
       }

       let trackToPlay = shuffle ? shufflePlaylist[currentPlaylistIndex] : currentPlaylist[currentPlaylistIndex];
       setTrack(trackToPlay, currentPlaylist, true);
   }

   function prevSong() {
       if(audioElement.audio.currentTime >= 3 || currentPlaylistIndex === 0){
           audioElement.setTime(0);
       }else{
           currentPlaylistIndex--;
           setTrack(currentPlaylist[currentPlaylistIndex], currentPlaylist, true);
       }

   }
   
   function setRepeat() {
        repeat = !repeat;
        let imageName = repeat ? "repeat-active.png" : "repeat.png";
        $(".control-button.repeat img").attr("src", "./assets/images/icons/" + imageName);
   }

   function setMute() {
       audioElement.audio.muted = !audioElement.audio.muted;
       let imageName = audioElement.audio.muted ? "volume-mute.png" : "volume.png";
       $(".control-button.volume img").attr("src", "./assets/images/icons/" + imageName);
   }

   function setShuffle() {
       shuffle = !shuffle;
       let imageName = shuffle ? "shuffle-active.png" : "shuffle.png";
       $(".control-button.shuffle img").attr("src", "./assets/images/icons/" + imageName);

       if(shuffle === true){
            shuffleArray(shufflePlaylist);
            currentPlaylistIndex = shufflePlaylist.indexOf(audioElement.currentPlaying.id);
       }else{
           currentPlaylistIndex = currentPlaylist.indexOf(audioElement.currentPlaying.id);
       }
   }

   function timeFromOffset(mouse, progressBar) {
       let percentage = mouse.offsetX / $(progressBar).width() * 100;
       let seconds = audioElement.audio.duration * (percentage / 100);

       audioElement.setTime(seconds);
   }

</script>

<div id="now-playing-bar-container">
    <div id="now-playing-bar">
        <div id="now-playing-left">
            <div class="content">
                    <span class="album-link">
                        <img  class="album-artwork" src="" alt="">
                    </span>
                <div class="track-info">
                        <span class="track-name">
                        <span></span>
                        </span>
                    <span class="artist-name">
                        <span></span>
                        </span>
                </div>
            </div>
        </div>
        <div id="now-playing-center">
            <div class="content player-controls">
                <div class="buttons">
                    <button class="control-button shuffle" title="Shuffle button" onclick="setShuffle()">
                        <img src="./assets/images/icons/shuffle.png" alt="Shuffle">
                    </button>

                    <button class="control-button previous" title="Previous button" onclick="prevSong()">
                        <img src="./assets/images/icons/previous.png" alt="Previous">
                    </button>

                    <button class="control-button play" title="Play button" onclick="playSong()">
                        <img src="./assets/images/icons/play.png" alt="Play">
                    </button>

                    <button class="control-button pause" title="Pause button" style="display: none" onclick="pauseSong()">
                        <img src="./assets/images/icons/pause.png" alt="Pause">
                    </button>

                    <button class="control-button next" title="Next button" onclick="nextSong()">
                        <img src="./assets/images/icons/next.png" alt="Next">
                    </button>

                    <button class="control-button repeat" title="Repeat button" onclick="setRepeat()">
                        <img src="./assets/images/icons/repeat.png" alt="Repeat">
                    </button>
                </div>
                <div class="playback-bar">
                    <span class="progress-time current">0:00</span>
                    <div class="progress-bar">
                        <div class="progress-bar-bg">
                            <div class="progress"></div>
                        </div>
                    </div>
                    <span class="progress-time remaining"></span>
                </div>
            </div>
        </div>
        <div id="now-playing-right">
            <div class="volume-bar">
                <button class="control-button volume" title="Volume button" onclick="setMute()">
                    <img src="./assets/images/icons/volume.png" alt="Volume">
                </button>
                <div class="progress-bar">
                    <div class="progress-bar-bg">
                        <div class="progress"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>