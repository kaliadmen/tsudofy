<?php
    include ("includes/config.php");

    if(isset($_SESSION['userLoggedIn'])){
        $userLoggedIn = $_SESSION['userLoggedIn'];
    } else{
        header("Location: register.php");
    }

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Tsudo Stream</title>
</head>
<body>
    <div id="main-container">
        <div id="top-container">
        <div id="navbar-container">
            <nav class="navbar">
                <a href="#" class="logo">
                    <img src="./assets/images/icons/logo.png" alt="Logo">
                </a>

                <div class="nav-item-container">
                    <div class="nav-item">
                        <a href="search.php" class="nav-item-link">Search
                            <img src="./assets/images/icons/search.png" class="icon" alt="Search"></a>
                    </div>
                </div>
                <div class="nav-item-container">
                    <div class="nav-item">
                        <a href="browse.php" class="nav-item-link">Browse</a>
                    </div>
                    <div class="nav-item">
                        <a href="your_music.php" class="nav-item-link">Your Music</a>
                    </div>
                    <div class="nav-item">
                        <a href="profile.php" class="nav-item-link">Kei Nagase</a>
                    </div>
                </div>
            </nav>
        </div>
        </div>
        <div id="now-playing-bar-container">
        <div id="now-playing-bar">
            <div id="now-playing-left">
                <div class="content">
                    <span class="album-link">
                        <img  class="album-artwork" src="./assets/images/test.png" alt="">
                    </span>
                    <div class="track-info">
                        <span class="track-name">
                        <span>Never Demo</span>
                        </span>
                        <span class="artist-name">
                        <span>Kaliadmen</span>
                        </span>
                    </div>
                </div>
            </div>
            <div id="now-playing-center">
                <div class="content player-controls">
                    <div class="buttons">
                        <button class="control-button shuffle" title="Shuffle button">
                            <img src="./assets/images/icons/shuffle.png" alt="Shuffle">
                        </button>

                        <button class="control-button previous" title="Previous button">
                            <img src="./assets/images/icons/previous.png" alt="Previous">
                        </button>

                        <button class="control-button play" title="Play button">
                            <img src="./assets/images/icons/play.png" alt="Play">
                        </button>

                        <button class="control-button pause" title="Pause button" style="display: none">
                            <img src="./assets/images/icons/pause.png" alt="Pause">
                        </button>

                        <button class="control-button next" title="Next button">
                            <img src="./assets/images/icons/next.png" alt="Next">
                        </button>

                        <button class="control-button repeat" title="Repeat button">
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
                        <span class="progress-time remaining">0:00</span>
                    </div>
                </div>
            </div>
            <div id="now-playing-right">
                <div class="volume-bar">
                    <button class="control-button volume" title="Volume button">
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
    </div>
</body>
</html>