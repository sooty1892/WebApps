$(document).ready(function (){

$("#editProject").on("hidden.bs.modal",function(){
   $('#edit_inputSection').val("");
   $(".sectionList").html("");
});


$("#edit_sectionsButton").click(function () {
    var name = $("#edit_inputSection").val();
//console.log(name);
    var sectionName ='id_' + name;
    var color= '<div style="position:relative; top:-15px; left:230px"><select name="colorpicker_' + name + '">';
              color += '<option value="#222222">Black</option><option value="#9b59b6">Purple</option><option value="#f1c40f">Yellow</option>';
              color += '<option value="#d35400">Orange</option><option value="#c0392b">Red</option><option value="#ecf0f1">White</option>';
              color += '<option value="#27ae60">Green</option></select></div>';
    var block = '</div><li id="' + sectionName+'" class="listItem">' + name + color+ '</li>';
    $('.sectionList').append(block);
    var select = 'select[name="colorpicker_'+name+'"]';
var name = '#' + sectionName;
 $(select).on('change', function() {
  $(this).parent().parent().css('background-color', $(this).val());
  if ($(this).val() == "#ecf0f1"){
      $(this).parent().parent().css('color', "black");
} else {
 $(this).parent().parent().css('color', "white");
}
});             
 $(select).simplecolorpicker({
  picker: true
})
$('#edit_inputSection').val("");
})
})


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
    var newGenre =  $("edit_#inputGenre").val();
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
   $.ajax({
        url: 'scripts/pull_project_data.php',
        type: 'GET',
        dataType: 'json',
        data: {idproject: '1'},
        success: function(response) {
          writeSectionList(response);
        },
        error: function(xhr,err){
                alert("readyState: "+xhr.readyState+"\nstatus: "+xhr.status);
                alert("responseText: "+xhr.responseText);
              }
      });
 

    $('#editProject').modal('show');
}


function fillDetails(response){
     
}
function generateTabsEdit() {
    var btnSkills = $("#edit_skill-list-p button");
    var btnGenres = $("#edit_genre-list button");

    var skills = "";
    var genres = "";

    for (var i = 0; i < btnSkills.length ; ++i) {
        skills = skills + "," + btnSkills[i].value;
    }
    for (var i = 0; i < btnGenres.length ; ++i) {
        genres = genres + "," + btnGenres[i].value;
    }

    $('#edit_hiddenSkills').attr("value", skills);
    $('#edit_hiddenGenres').attr("value", genres);


    var sec = "";
    $.each($('.sectionList').sortable( "toArray"), function( index, value ) {
          sec += "," + value;
    });
    $('#hiddenSections').attr("value", sec);
    return true;
}