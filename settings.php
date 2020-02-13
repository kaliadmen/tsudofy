<?php include("./includes/includedFiles.php"); ?>

<div class="entity-info">
    <div class="center-section">
        <div class="user-info">
            <h1><?php echo $loggedInUser->getFirstAndLastName();?></h1>
        </div>
    </div>

    <div class="button-items">
        <button class="button" onclick="openPage('updateUser.php')">USER DETAILS</button>
        <button class="button" onclick="logout()">LOGOUT</button>
    </div>
</div>
