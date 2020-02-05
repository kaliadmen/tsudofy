var currentPlaylist = [];
var shufflePlaylist = [];
var tempPlaylist = [];
var currentPlaylistIndex = 0;
var audioElement;
var loggedInUser;
var timer;
var mouseDown = false;
var repeat = false;
var shuffle = false;

function Audio(){

    this.currentPlaying;
    this.audio = document.createElement('audio');

    this.audio.addEventListener('canplay', function() {
        //'this' refers to the audio object that the event is called from
        $(".progress-time.remaining").text(formatTime(this.duration));
    });

    this.audio.addEventListener('timeupdate', function() {
        if(this.duration){
            updateTimeProgressBar(this);
        }
    });

    this.audio.addEventListener("volumechange", function() {
        updateVolumeProgressBar(this);
    });

    this.audio.addEventListener("ended", function() {
        nextSong();
    });

    this.setTrack = function(track) {
        this.currentPlaying = track;
        this.audio.src = track.path;
    };

    this.play = function() {
        this.audio.play();
    };

    this.pause = function(){
        this.audio.pause();
    };

    this.setTime = function(seconds) {
        this.audio.currentTime = seconds;
    }
}

function formatTime(seconds) {
    var time = Math.round(seconds);
    var mins = Math.floor(time/60);
    var secs = time - mins * 60;
    var addedZero = (secs < 10) ? '0' : '';

    return mins + ":" + addedZero + secs;
}

function updateTimeProgressBar(audio) {
    var progress = audio.currentTime / audio.duration * 100;

    $(".progress-time.current").text(formatTime(audio.currentTime));
    $(".progress-time.remaining").text(formatTime(audio.duration - audio.currentTime));
    $(".playback-bar .progress").css("width", progress + "%");
}

function updateVolumeProgressBar(audio) {
    var volume = audio.volume * 100;

    $(".volume-bar .progress").css("width", volume + "%");
}

function shuffleArray(array) {
    for (var i = array.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [array[i], array[j]] = [array[j], array[i]];
    }
    return array;
}

function openPage(url) {
    if(timer !== null){
        clearTimeout(timer);
    }

    if(url.indexOf("?") === -1){
        url = url + "?";
    }
    var encodedUrl = encodeURI(url + "&loggedInUser=" + loggedInUser);
    $("#main-content").load(encodedUrl);
    $("body").scrollTop(0);
    history.pushState(null, null, url);
}

function playFirstSong() {
    setTrack(tempPlaylist[0], tempPlaylist, true);
}

// TODO Refactor to not use default prompt
function createPlaylist(){
    var alertPrompt = prompt("PLease enter the name of your playlist");

    if(alertPrompt !== ''){
        $.post("./includes/handlers/ajax/createPlaylist.php", {name: alertPrompt, username: loggedInUser})
            .done(function(error) {
                if(error){
                    alert(error);
                }
                else{
                    openPage("your_music.php");
                }
            })
    }else{
        alert("error");
    }
}

function deletePlaylist(playlistId){
    var alertPrompt = confirm("Are you sure you want to delete this playlist?");

    if(alertPrompt){
        $.post("./includes/handlers/ajax/deletePlaylist.php", {playlistId: playlistId})
            .done(function(error) {
                if(error){
                    alert(error);
                }
                else{
                    openPage("your_music.php");
                }
            })
    }else{
        alert("Error");
    }
}