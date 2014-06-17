function addSkillsProject() {
    var newSkill = $("#edit_inputSkill").val();
    if (newSkill != "") {
        $("#edit_skill-list-p").append("\n<li><button type=\"button\" class=\"btn-primary\" disabled value = \"" 
                                + newSkill  + "\">" 
                               + newSkill + "<span class=\"close\" style =\"display: block\">x</span></button></li>");
        $("#edit_inputSkill").val("");
        $(document).on("click", ".close", buttonFade);
    }
}

function addGenre() {
    var newGenre = $("edit_#inputGenre").val();
    if (newGenre != "") {
        $("#edit_genre-list").append("\n<li><button type=\"button\" class=\"btn-primary\" disabled value = \"" 
                                + newGenre  + "\">" 
                               + newGenre + "<span class=\"close\" style =\"display: block\">x</span></button></li>");
        $("#edit_inputGenre").val("");
        $(document).on("click", ".close", buttonFade);
    }
}

var buttonFadeNew = function () {
    $(this).parent().fadeOut(400, function() {
            $(this).parent().remove();
    });
}

function showEditModal() { 
    $('#editProject').modal('show');
}


function fillDetails(response){
     
}
function generateTabs() {
    var btnSkills = $("#edit_skill-list-p button");
    var btnGenres = $("#edit_genre-list button");

    var skills = "";
    var genres = "";

    for(var i = 0; i < btnSkills.length ; ++i) {
        skills = skills + "," + btnSkills[i].value;
    }
    for(var i = 0; i < btnGenres.length ; ++i) {
        genres = genres + "," + btnGenres[i].value;
    }

    $('#edit_hiddenSkills').attr("value", skills);
    $('#edit_hiddenGenres').attr("value", genres);

    return true;
}