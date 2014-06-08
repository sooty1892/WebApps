function valLoginForm() {
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

function pulseMessage() {
    for(var i = 0; i < 2 ; ++i){
        $("#login-error").fadeOut(200);
        $("#login-error").fadeIn(200);
    }
}

function valSubmitForm() {
    var password = document.getElementById("user-password").value;
    var passwordConfirm = document.getElementById("user-password-confirm").value;

    //stores error messages - functions return error message
    //if no errors string is empty
    var userError = valUsername(document.getElementById("user-login").value);
    var emailError = valEmail(document.getElementById("user-email").value);
    var passwordError = valPassword(password);
    var passwordConfirmError = "";

    if (passwordConfirm == '') {
        passwordConfirmError = "Password is required";
    }

    if (passwordError == "" && passwordConfirmError == "" && password != passwordConfirm) {
        passwordConfirmError = "Passwords must match";
    }

    handleError("username-error", userError, 0);
    handleError("email-error", emailError, 200);
    handleError("password-error", passwordError, 400);
    handleError("password-match-error", passwordConfirmError, 600);

    return userError == "" &&
           emailError == "" && 
           passwordError == "" &&
           passwordConfirmError == "";
};

function handleError(name, error, time) {
    if (error != "") {
        document.getElementById(name).innerHTML = error;
        setTimeout(function(){$('#' + name).slideDown("slow");}, time);
    } else {
        setTimeout(function(){$('#' + name).slideUp("slow");}, time);
    }
};

function valUsername(username) {
    var reg = /[a-zA-Z0-9]/;
    var error = "";
    if (username == '') {
        error = "Username is required";
    } else if (username.length > 20) {
        error = "Username too long (max 20 characters)";
    } else if (!reg.test(username)) {
        error = "Only letters and numbers allowed";
    } else if (checkUsernameExist(username) == 1) {
        error = "Username already exists";
    }
    return error;
}

function valEmail(email) {
    var reg = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    var error = "";
    if (email == '') {
        error = "Email is required"
    } else if (email.length > 256) {
        error = "Email address too long (max 256 characters)"
    } else if (!reg.test(email)) {
        error = "Please enter a valid email address"
    } else if (checkEmailExist(email) == 1) {
        error = "Email is already registered"
    }
    return error;
}

function valPassword(password) {
    var reg1 = /.*[0-9].*/;
    var reg2 = /.*[a-z].*/;
    var reg3 = /.*[A-Z].*/;
    var error = "";
    if (password == '') {
        error = "Password is required";
    } else if (password.length < 6) {
        error = "Password needs to have at least 6 characters!";
    } else if (password.length > 20) {
        error = "Password needs to have less than 20 characters!";
    } else if (!reg1.test(password)) {
        error = "Password must include at least one number!";
    } else if (!reg2.test(password)) {
        error = "Password must include at least one letter!";
    } else if (!reg3.test(password)) {
        error = "Password must include at least one uppercase letter!";
    }
    return error;
}

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
};

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

