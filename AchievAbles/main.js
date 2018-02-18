$(document).ready(function(){
    $("#signUp").click(function(){
        $("#signupModal").modal();
    });
    
    $("#logIn").click(function(){
        $("#loginModal").modal();
    });
    
    $("#contactUs").click(function(){
        $("#contactModal").modal();
    });
});

   function emailValidate(){
    var regex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})$/g;
    var email = document.getElementById('email1');
    var emailerror = document.getElementById('email1-error');
    var submitbtn = document.getElementById('signup-submit');
    if (regex.test(email.value)){
        
            emailerror.innerHTML = "";
            submitbtn.disabled = false;
        }
    else{
            emailerror.innerHTML = "Invalid email.";
            submitbtn.disabled = true;
        }
   }
   
   function usernameValidate(){
       var username = document.getElementById('usrname1');
       var usererror = document.getElementById('usrerror1');
       var submitbtn = document.getElementById('signup-submit');
       
       if (username.value.length < 1){
           usererror.innerHTML = "Username is required.";
           submitbtn.disabled = true;
       }
       
       else {
           usererror.innerHTML = "";
           submitbtn.disabled = false;
       }
   }
   
   function passValidate() {
       var passwrd = document.getElementById('passwrd1');
       var passerror = document.getElementById('passerror1');
       var submitbtn = document.getElementById('signup-submit');
       
       if (passwrd.value.length < 8){
           passerror.innerHTML = "Password must be at least 8 characters long.";
           submitbtn.disabled = true;
       }
       
       else {
           passerror.innerHTML = "";
           submitbtn.disabled = false;
       }
   }

    function confirmValid() {
        var passwrd = document.getElementById('passwrd1');
        var passconfirm = document.getElementById('passwrdCfrm1');
        var passconfirmErr = document.getElementById('passconfirmerror');
        var submitbtn = document.getElementById('signup-submit');
        
        if (passwrd.value !== passconfirm.value){
            passconfirmErr.innerHTML = "Passwords don't match!";
            submitbtn.disabled = true;
        }
        
        else {
            passconfirmErr.innerHTML = "";
            submitbtn.disabled = false;
        }
    }
    
    function signUpSubmit() {
        
    }


