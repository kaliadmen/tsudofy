$(document).ready(function() {
    $("#hide-login").click(function() {
        $("#login-form").hide();
        $("#register-form").show();
    });

    $("#hide-register").click(function() {
        $("#login-form").show();
        $("#register-form").hide();
    });

    function hideMsg(){
        $(".errorMessage").fadeOut();
    }
    setTimeout(hideMsg,5000);
});