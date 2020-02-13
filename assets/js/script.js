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
    var alertPrompt = prompt("Please enter the name of your playlist");

    if(alertPrompt !== '' && alertPrompt !== null){
        $.post("./includes/handlers/ajax/createPlaylist.php", {name: alertPrompt, username: loggedInUser})
            .done(function(error) {
                if(error){
                    alert(error);
                    return;
                }
                else{
                    openPage("your_music.php");
                }
            })
    }else{
        alert("error");
    }
}

// TODO Refactor to not use default prompt
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

function deleteFromPlaylist(button, playlistId) {
    var songId = $(button).prevAll(".song-id").val();

    $.post("./includes/handlers/ajax/deleteFromPlaylist.php", { playlistId: playlistId ,songId: songId})
        .done(function(error) {
            if (error) {
                alert(error);
            }

            openPage("playlist.php?id=" + playlistId);
        });
}

function showOptionsMenu(button) {
    var songId = $(button).prev(".song-id").val();
    var menu = $(".options-menu");
    var menuWidth = menu.width() + 5; // adds 5 px to menu width
    var scrollTop = $(window).scrollTop(); // distance from top of window to top of document
    var elementOffset = $(button).offset().top; // distance from top pf document
    var top = elementOffset - scrollTop;
    var left = $(button).position().left;

    menu.find(".song-id").val(songId);

    menu.css({"top": top + "px", "left": left - menuWidth + "px", "display": "inline"});
}

function hideOptionsMenu() {
    var menu = $(".options-menu");

    if(menu.css("display") !== "none"){
        menu.css("display", "none");
    }
}

function logout(){
    $.post("./includes/handlers/ajax/logout.php",function() {
        location.reload();
    })
}

function updateEmail(emailClass){
    var emailValue = $("." + emailClass).val();

    $.post("./includes/handlers/ajax/updateEmail.php", {email: emailValue, username: loggedInUser})
        .done(function(res) {
            $("." + emailClass).nextAll(".message").text(res);
            hideMsg(".message");
        })
}

function updatePassword(oldPasswordClass, newPasswordClass, newPasswordConfirmedClass){
    var oldPasswordValue = $("." + oldPasswordClass).val();
    var newPasswordValue = $("." + newPasswordClass).val();
    var newPasswordConfirmedValue = $("." + newPasswordConfirmedClass).val();

    $.post("./includes/handlers/ajax/updatePassword.php",
        {oldPassword: oldPasswordValue,
         newPassword: newPasswordValue,
         confirmedPassword: newPasswordConfirmedValue,
         username: loggedInUser
        }).done(function(res) {
            $("." + oldPasswordClass).nextAll(".message").text(res);
            hideMsg(".message");
        });
}

$(document).click(function(clickEvent) {
    var target = $(clickEvent.target);

    if(!target.hasClass("item") && !target.hasClass("options-button")){
        hideOptionsMenu();
    }
});

$(window).scroll(function() {
    hideOptionsMenu();
});

$(document).on("change", "select.playlist", function() {
    var select = $(this);
    var playlistId = select.val();
    var songId = select.prev(".song-id").val();

    $.post("./includes/handlers/ajax/addToPlaylist.php", {playlistId: playlistId, songId: songId})
        .done(function(error) {
            if(error){
                alert(error);
                return;
            }
            hideOptionsMenu();
            select.val("");
        });
});


function hideMsg(el){
    $(el).fadeOut(5000,"linear",function() {
        $(".message").text("");
        $(".message").css("display", "block");
    });
    }

