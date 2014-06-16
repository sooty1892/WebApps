function addSkillsProject() {
    var newSkill = $("#inputSkill").val();
    if (newSkill != "") {
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
        $("#genre-list").append("\n<li><button type=\"button\" class=\"btn-primary\" disabled value = \"" 
                                + newGenre  + "\">" 
                               + newGenre + "<span class=\"close\" style =\"display: block\">x</span></button></li>");
        $("#inputGenre").val("");
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

function pullData(){
   $.ajax({
        url: 'scripts/pull_project_data.php',
        type: 'GET',
        dataType: 'json',
        data: {idproject: '1'},
        success: function(response) {
          fillDetails(response);
           
        },
        error: function(xhr,err){
                alert("readyState: "+xhr.readyState+"\nstatus: "+xhr.status + "NNNNNNNOOOOOOOO");
                alert("responseText: "+xhr.responseText);
              }
      });

    }
function fillDetails(response){
     
}
function generateTabs() {
    var btnSkills = $("#skill-list-p button");
    var btnGenres = $("#genre-list button");

    var skills = "";
    var genres = "";

    for(var i = 0; i < btnSkills.length ; ++i) {
        skills = skills + "," + btnSkills[i].value;
    }
    for(var i = 0; i < btnGenres.length ; ++i) {
        genres = genres + "," + btnGenres[i].value;
    }

    $('#hiddenSkills').attr("value", skills);
    $('#hiddenGenres').attr("value", genres);

    return true;
}
