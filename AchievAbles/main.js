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

    $("#forgot").click(function () {
        $("#forgotModal").modal();
    });

    $("#deleteAccount").click(function () {
        $("#deleteModal").modal();
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

function forgotPassword() {


    var emailTo = 'vkmontalvo@email.neit.edu';
    var emailCC = 'valeriekmontalvo@gmail.com';
    var emailSubject = 'Forgotten AchievAbles Login Credentials';
    var emailBody = "Hello!%0D%0A%0D%0AI've forgotten my login credentials. Can you help?%0D%0A%0D%0AThe email address I used for my account is: [type your email address here]";

    window.open('mailto:' + emailTo + '?cc=' + emailCC + '&subject=' + emailSubject + '&body=' + emailBody);

}

function contactUs() {


    var emailTo = 'vkmontalvo@email.neit.edu';
    var emailCC = 'valeriekmontalvo@gmail.com';
    var emailSubject = 'AchievAbles Help';
    var emailBody = "{Type your message here. Please allow up to 48 hours for a response.}";

    window.open('mailto:' + emailTo + '?cc=' + emailCC + '&subject=' + emailSubject + '&body=' + emailBody);

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

function loginValidate() {
    var username = document.getElementById('usrname2');
    var loginerror = document.getElementById('login-error');
    var passwrd = document.getElementById('passwrd2');
    var submit = document.getElementById('login-submit');

    jQuery.ajax({
        url: "loginValidate.php",
        data: {username: username.value, password: passwrd.value},
        type: "POST",
        dataType: 'JSON',
        success: function (data) {
            loginerror.innerHTML = data;

            if (data !== '') {

                submit.disabled = true;
            } else {
                submit.disabled = true;
            }
        },
        error: function () {}

    });
}

//============================================================
// Account Functions
//============================================================
function logout() {
    jQuery.ajax({
        url: "logout.php",
        data: "logout=" + true,
        type: "POST",
        success: function () {
            window.location.replace("index.php");
        },
        error: function () {}

    });
}

//============================================================
// Account Edit Functions
//============================================================

function emailCheck() {
    var email = document.getElementById('email');
    var emailconf = document.getElementById('email-conf');
    var editErr = document.getElementById('edit-error');
    var submited = document.getElementById('submit-edit');
    var regex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})$/g;

    if (email.value !== emailconf.value) {
        editErr.innerHTML = "Email entries do not match.";
        submited.disabled = true;
    } else if (email.value.length < 1) {
        editErr.innerHTML = "No email address entered.";
        submited.disabled = true;
    } else if (!regex.test(email.value)) {
        editErr.innerHTML = "Invalid email.";
        submited.disabled = true;
    } else {
        editErr.innerHTML = "";
        submited.disabled = false;
    }
}

function passCheck() {
    var pwd = document.getElementById('passwrd');
    var pwdConf = document.getElementById('passwrd-conf');
    var submited = document.getElementById('submit-edit');
    var editErr = document.getElementById('edit-error');

    if (pwd.value.length < 8) {
        editErr.innerHTML = "Password must be at least 8 characters.";
        submited.disabled = true;
    } else if (pwd.value !== pwdConf.value) {
        editErr.innerHTML = "Password entries do not match.";
        submited.disabled = true;
    } else if (pwdConf.value.lenth < 1) {
        editErr.innerHTML = "Please confirm password.";
        submited.disabled = true;
    } else {
        editErr.innerHTML = "";
        submited.disabled = false;
    }
}

