let currentPlaylist = [];
let shufflePlaylist = [];
let tempPlaylist = [];
let currentPlaylistIndex = 0;
let audioElement;
let mouseDown = false;
let repeat = false;
let shuffle = false;


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
    let time = Math.round(seconds);
    let mins = Math.floor(time/60);
    let secs = time - mins * 60;
    let addedZero = (secs < 10) ? '0' : '';

    return mins + ":" + addedZero + secs;
}

function updateTimeProgressBar(audio) {
    let progress = audio.currentTime / audio.duration * 100;

    $(".progress-time.current").text(formatTime(audio.currentTime));
    $(".progress-time.remaining").text(formatTime(audio.duration - audio.currentTime));
    $(".playback-bar .progress").css("width", progress + "%");
}

function updateVolumeProgressBar(audio) {
    let volume = audio.volume * 100;

    $(".volume-bar .progress").css("width", volume + "%");
}

function shuffleArray(array) {
    for (let i = array.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [array[i], array[j]] = [array[j], array[i]];
    }
    return array;
}