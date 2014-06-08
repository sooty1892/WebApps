//var currentSongPlaying = null;
var currentActiveButton = null;

$(document).ready(function() {
    $("span.close").click(function () {
          $(this).parent().fadeOut(400, function() {
              $(this).parent().remove();
          });
    });           
})

function editModeUser() {
    $("#btnEdit").slideToggle(400, function() { 
        $("#btnsChanges").slideToggle(400);
    });
} 

function cancelUser() {
    $("#btnsChanges").slideToggle(400, function() { 
        $("#btnEdit").slideToggle(400);
    });
}

function saveChangesUser() {
    $("#btnsChanges").slideToggle(400, function() { 
        $("#btnEdit").slideToggle(400);
    });
}

function editAboutMe() {
    $("#btnEditAbout").fadeOut(300, function() { 
        $("#aboutChanges").fadeIn(300);
    });
    document.getElementById("aboutArea").disabled = false;
}

function saveAboutMe() {
    $("#aboutChanges").fadeOut(300, function() { 
        $("#btnEditAbout").fadeIn(300);
    });
    document.getElementById("aboutArea").disabled = true;
}

function editSkills() {
    // Make sure to come back to this, make use of the each method
    var btnSkills = $("#skill-list button");
    var btnSpans = $("#skill-list span");
    
    for(var i = 0; i < btnSkills.length ; ++i) {
        btnSkills[i].disabled = true;
        btnSpans[i].style.display = "block";
    }
    $("#btnEditSkills").fadeOut(300, function() { 
        $("#btnsSkillEdits").fadeIn(300);
    });
}

function cancelSkills() {
    var btnSkills = $("#skill-list button");
    var btnSpans = $("#skill-list span");
    
    for(var i = 0; i < btnSkills.length ; ++i) {
        btnSkills[i].disabled = false;
        btnSpans[i].style.display = "none";
    }
    
    $("#btnsSkillEdits").fadeOut(300, function() { 
        $("#btnEditSkills").fadeIn(300);
    });
}

function addSkills() {
    var newSkill = $("#skillField").val();
    if (newSkill != "") {
        $("#skill-list").append("\n<li><button type=\"button\" class=\"btn-primary\" disabled>" 
                               + newSkill + "<span class=\"close\" style =\"display: block\">x</span></button></li>");
        $("#skillField").val("");
        $(document).on("click", ".close", buttonFade);
    }
}

var buttonFade = function () {
    $(this).parent().fadeOut(400, function() {
            $(this).remove();
    });
} 

function cancelAboutMe() {
    $("#aboutChanges").fadeOut(400, function() { 
        $("#btnEditAbout").fadeIn(400);
    });
    document.getElementById("aboutArea").disabled = true;
}

function activateSong(){
    var btn = $(event.target);
    var img = btn.children("img");
    
    if (currentActiveButton == null) {
        alert("no current");
        currentActiveButton = btn;
        img[0].style.display = "inline";
        btn.toggleClass("active");
    } else {
        var activeImg = currentActiveButton.children("img");
        activeImg[0].style.display = "none";
        currentActiveButton.toggleClass("active");
    
        if (btn.isEqualNode(currentActiveButton)) {
            alert("same!");
            currentActiveButton = null;
        } else {
            btn.toggleClass("active");
            img[0].style.display = "inline";
            currentActiveButton = btn;
        }
    }
    
}