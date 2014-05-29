$(document).ready(function() {
    $("#jumbo").animate({left : "+=1300"}, 1450, "easeOutBounce");
    $("#about").animate({right : "+=1300"}, 1450, "easeOutBounce");        
});

function valForm() {
    var user = document.getElementById("username").value;
    var pass = document.getElementById("password").value;

    if (user == '' || pass == '') {
        $("#login-error").slideDown("slow"); 
        return false;
    } else if (checkLogin(user, pass) != 1) {
        $("#login-error").slideDown("slow"); 
        return false;
    } else {
        $("#login-error").slideUp("slow");
        return true;
    }
};

function checkLogin(user, pass) { 
    var result = $.ajax({
        type: 'POST',
        url: "check_login.php",
        data: { username: user, password: pass},
        success: function(response) {
            return response;
        },
        async: false,
    });
    return result.responseText;
}

function validateForm() {
    var userLogin = document.getElementById("user-login").value;
    var userEmail = document.getElementById("user-email").value;
    var password = document.getElementById("user-password").value;
    var passwordConfirm = document.getElementById("user-password-confirm").value;

    //checking if values are correct
    var userCorrect = false;
    var emailCorrect = false;
    var passwordCorrect = false;
    var passwordConfirmCorrect = false;
    //stores error messages
    var userError, emailError, passwordError, passwordConfirmError;

    var reg = /[a-zA-Z0-9]/;
    if (userLogin == '') {
        userError = "Username is required";
    } else if (userLogin.length > 20) {
        userError = "Username too long (max 20 characters)";
    } else if (!reg.test(userLogin)) {
        userError = "Only letters and numbers allowed";
    } else if (checkUsernameExist(userLogin) == 1) {
        userError = "Username already exists";
    } else {
        userCorrect = true;
    }

    reg = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if (userEmail == '') {
        emailError = "Email is required"
    } else if (userEmail.length > 256) {
        emailError = "Email address too long (max 256 characters)"
    } else if (!reg.test(userEmail)) {
        emailError = "Please enter a valid email address"
    } else if (checkEmailExist(userEmail) == 1) {
        emailError = "Email is already registered"
    } else {
        emailCorrect = true;
    }

    var reg1 = /.*[0-9].*/;
    var reg2 = /.*[a-z].*/;
    var reg3 = /.*[A-Z].*/;
    if (password == '') {
        passwordError = "Password is required";
    } else if (password.length < 6) {
        passwordError = "Password needs to have at least 6 characters!";
    } else if (password.length > 20) {
        passwordError = "Password needs to have less than 20 characters!";
    } else if (!reg1.test(password)) {
        passwordError = "Password must include at least one number!";
    } else if (!reg2.test(password)) {
        passwordError = "Password must include at least one letter!";
    } else if (!reg3.test(password)) {
        passwordError = "Password must include at least one uppercase letter!";
    } else {
        passwordCorrect = true;
    }

    if (passwordConfirm == '') {
        passwordConfirmError = "Password is required";
    } else {
        passwordConfirmCorrect = true;
    }

    if (passwordCorrect && passwordConfirmCorrect && password != passwordConfirm) {
        passwordConfirmCorrect = false;
        passwordConfirmError = "Passwords must match";
    }

    handleError(userCorrect, "username-error", userError, 0);
    handleError(emailCorrect, "email-error", emailError, 200);
    handleError(passwordCorrect, "password-error", passwordError, 400);
    handleError(passwordConfirmCorrect, "password-match-error", passwordConfirmError, 600);

    if (userCorrect && emailCorrect && passwordCorrect && passwordConfirmCorrect) {
        return true;
    } else {
        return false;
    }
};

function handleError(correct, name, error, time) {
    if (correct == false) {
        document.getElementById(name).innerHTML = error;
        setTimeout(function(){$('#' + name).slideDown("slow");}, time);
    } else {
        document.getElementById(name).innerHTML = "";
        setTimeout(function(){$('#' + name).slideUp("slow");}, time);
    }
};

function checkEmailExist(email) {
    var result = $.ajax({
        type: 'POST',
        url: "check_email.php",
        data: { email: email},
        success: function(response) {
            return response;
        },
        async: false,
    });
   return result.responseText;
}

function checkUsernameExist(username) {
   var result = $.ajax({
        type: 'POST',
        url: "check_username.php",
        data: { username: username},
        success: function(response) {
            return response;
        },
        async: false,
    });
   return result.responseText;
};

