function addSkills() {
    var newSkill = $("#inputSkill").val();
    if (newSkill != "") {
        $("#skill-list-p").append("\n<li><button type=\"button\" class=\"btn-primary\" disabled>" 
                               + newSkill + "<span class=\"close\" style =\"display: block\">x</span></button></li>");
        $("#inputSkill").val("");
        $(document).on("click", ".close", buttonFade);
    }
}

function addGenre() {
    var newGenre = $("#inputGenre").val();
    if (newGenre != "") {
        $("#genre-list").append("\n<li><button type=\"button\" class=\"btn-primary\" disabled>" 
                               + newGenre + "<span class=\"close\" style =\"display: block\">x</span></button></li>");
        $("#inputGenre").val("");
        $(document).on("click", ".close", buttonFade);
    }
}

var buttonFade = function () {
    $(this).parent().fadeOut(400, function() {
            $(this).parent().remove();
    });
}

function showModal() {
    $('#newProject').modal('show');
}