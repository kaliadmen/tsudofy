<?php include("./includes/includedFiles.php"); ?>

<div class="user-details">
    <div class="container border-bottom">
        <h2>EMAIL</h2>
        <input type="text" name="email" class="email" placeholder="Email address..." value="<?php echo $loggedInUser->getEmail(); ?>">
        <span class="message"></span>
        <button class="button" onclick="updateEmail('email')">SAVE</button>
    </div>
    <div class="container">
        <h2>PASSWORD</h2>
        <input type="password" name="old-password" class="old-password" placeholder="Current password">
        <input type="password" name="new-password" class="new-password" placeholder="New password">
        <input type="password" name="confirm-password" class="confirm-password" placeholder="Confirm password">
        <span class="message"></span>
        <button class="button" onclick="updatePassword('old-password', 'new-password', 'confirm-password')">SAVE</button>
    </div>
</div>