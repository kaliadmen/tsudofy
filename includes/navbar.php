<div id="navbar-container">
    <nav class="navbar">
        <span role="link" tabindex="0" onclick="openPage('index.php')" class="logo">
            <img src="./assets/images/icons/logo.png" alt="Logo">
        </span>

        <div class="nav-item-container">
            <div class="nav-item">
                <span role="link"tabindex="0" onclick="openPage('search.php')" class="nav-item-link">Search
                    <img src="./assets/images/icons/search.png" class="icon" alt="Search">
                </span>
            </div>
        </div>
        <div class="nav-item-container">
            <div class="nav-item">
                <span role="link" tabindex="0" onclick="openPage('browse.php')" class="nav-item-link">Browse</span>
            </div>
            <div class="nav-item">
                <span role="link" tabindex="0" onclick="openPage('your_music.php')" class="nav-item-link">Your Music</span>
            </div>
            <div class="nav-item">
                <span role="link" tabindex="0" onclick="openPage('settings.php')" class="nav-item-link"><?php echo $loggedInUser->getUsername();?></span>
            </div>
        </div>
    </nav>
</div>