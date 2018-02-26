//============================================================
// Modals
//============================================================

$(document).ready(function () {
    $("#signUp").click(function () {
        $("#signupModal").modal();
    });

    $("#logIn").click(function () {
        $("#loginModal").modal();
    });

    $("#contactUs").click(function () {
        $("#contactModal").modal();
    });

    $("#forgot").click(function () {
        $("#forgotModal").modal();
    });
});

//============================================================
// Validation Functions
//============================================================
function emailValidate() {
    var regex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})$/g;
    var email = document.getElementById('email1');
    var emailerror = document.getElementById('email1-error');
    var submitbtn = document.getElementById('signup-submit');
    if (regex.test(email.value)) {

        jQuery.ajax({
            url: "checkemail.php",
            data: "email=" + email.value,
            type: "POST",
            success: function (data) {
                emailerror.innerHTML = data;

                if (data !== '') {
                    submitbtn.disabled = true;
                } else {
                    submitbtn.disabled = false;
                }
            },
            error: function () {}
        });

    } else {
        emailerror.innerHTML = "Invalid email.";
        submitbtn.disabled = true;
    }
}

function usernameValidate() {
    var reg = /^[\w\.0-9]+$/g;
    var username = document.getElementById('usrname1');
    var usererror = document.getElementById('usrerror1');
    var submitbtn = document.getElementById('signup-submit');

    if (username.value.length < 1) {
        usererror.innerHTML = "Username is required.";
        submitbtn.disabled = true;
    } else if (username.value.length > 10 || reg.test(username.value) === false) {
        usererror.innerHTML = "Username must be no more than 10 characters and can only contain<br>alphanumeric characters, undescores or periods.";
        submitbtn.disabled = true;
    } else {
        jQuery.ajax({
            url: "usernameCheck.php",
            data: "username=" + username.value,
            type: "POST",
            success: function (data) {
                usererror.innerHTML = data;

                if (data !== '') {
                    submitbtn.disabled = true;
                } else {
                    submitbtn.disabled = false;
                }
            },
            error: function () {}

        });
    }
}

function checkEmail() {
    var email = document.getElementById('forgot-email');
    var forgoterr = document.getElementById('forgot-error');

    jQuery.ajax({
        url: "forgot.php",
        data: "email=" + email.value,
        type: "POST",
        success: function (data) {
            forgoterr.innerHTML = data;
        },
        error: function () {}
    });
}



function passValidate() {
    var passwrd = document.getElementById('passwrd1');
    var passerror = document.getElementById('passerror1');
    var submitbtn = document.getElementById('signup-submit');

    if (passwrd.value.length < 8) {
        passerror.innerHTML = "Password must be at least 8 characters long.";
        submitbtn.disabled = true;
    } else {
        passerror.innerHTML = "";
        submitbtn.disabled = false;
    }
}

function confirmValid() {
    var passwrd = document.getElementById('passwrd1');
    var passconfirm = document.getElementById('passwrdCfrm1');
    var passconfirmErr = document.getElementById('passconfirmerror');
    var submitbtn = document.getElementById('signup-submit');

    if (passwrd.value !== passconfirm.value) {
        passconfirmErr.innerHTML = "Passwords don't match!";
        submitbtn.disabled = true;
    } else {
        passconfirmErr.innerHTML = "";
        submitbtn.disabled = false;
    }
}



