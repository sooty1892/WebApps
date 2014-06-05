$(document).ready(function() {
    $("#jumbo").animate({left : "+=1300"}, 1450, "easeOutBounce")
    $("#about").animate({right : "+=1300"}, 1450, "easeOutBounce") 
    
    $("#btnLogin").click(function () {
        /* Will need to add some validtion here and then make use of
           of the the slideDown animation. AJAX is required here */
        /*var usr = document.getElementById("username");
        var passwrd = document.getElementById("password");
        
        if(usr.value != passwrd.value) {
            $("#login-error").slideDown("slow");   
        } else {
            $("#login-error").slideUp("slow");
        }*/

        $("#login-error").slideDown("slow")
    })
    
    $("#btnSignUp").click(function () {
        var userLogin = document.getElementById("user-login")
        var userEmail = document.getElementById("user-email")
        var password = document.getElementById("user-password")
        var passwordConfirm = document.getElementById("user-password-confirm")
        
        if (password.value != passwordConfirm.value) {
            document.getElementById("password-match").innerHTML = "Passwords do no match"
            $("#password-match").slideDown("slow")
        } else if (password.value == "" && passwordConfirm.value == "") {
            document.getElementById("password-match").innerHTML = "Please enter a suitable password"
            $("#password-match").slideDown("slow")
        } else {
            $("#password-match").slideUp("slow")
        }
    })
})
