function addSkillsProject() {
    var newSkill = $("#inputSkill").val();
    if (newSkill != "") {
        $("#hiddenSkills").attr("value", ($("#hiddenSkills").attr("value") + ',' + newSkill));
        $("#skill-list-p").append("\n<li><button type=\"button\" class=\"btn-primary\" disabled value = \"" 
                                + newSkill  + "\">" 
                               + newSkill + "<span class=\"close\" style =\"display: block\">x</span></button></li>");
        $("#inputSkill").val("");
        $(document).on("click", ".close", buttonFade);
    }
}

function addGenre() {
    var newGenre = $("#inputGenre").val();
    if (newGenre != "") {
        $("#hiddenGenres").attr("value", ($("#hiddenGenres").attr("value") + ',' + newSkill));
        $("#genre-list").append("\n<li><button type=\"button\" class=\"btn-primary\" disabled value = \"" 
                                + newGenre  + "\">" 
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