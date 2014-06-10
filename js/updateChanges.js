var currentActiveButton = null;

$(document).ready(function() {
    $("span.close").click(function () {
          $(this).parent().fadeOut(400, function() {
              $(this).parent().remove();
          });
    });           
})

function editModeUser() {
    $("#btnEdit").fadeToggle(400, function() { 
        $("#btnsChanges").fadeToggle(400);
    });
    document.getElementById("userRealName").disabled = false;
} 

function cancelUser() {
    $("#btnsChanges").fadeToggle(400, function() { 
        $("#btnEdit").fadeToggle(400);
    });
    $("#files").empty();
    $("#progress .progress-bar").css("width","0%");
    document.getElementById("userRealName").disabled = true;
}

function saveChangesUser() {
    $("#btnsChanges").fadeToggle(400, function() { 
        $("#btnEdit").fadeToggle(400);
    });
    $("#files").empty();
    $("#progress .progress-bar").css("width","0%");
    document.getElementById("userRealName").disabled = true;
}

function editAboutMe() {
    $("#btnEditAbout").fadeOut(300, function() { 
        $("#aboutChanges").fadeIn(300);
    });
    document.getElementById("aboutArea").disabled = false;
}

function saveAboutMe(username) {
    $("#aboutChanges").fadeOut(300, function() { 
        $("#btnEditAbout").fadeIn(300);
    });
    document.getElementById("aboutArea").disabled = true;
    $.ajax({
        type: 'POST',
        url: "save_about.php",
        data: { username: username,
                about: document.getElementById("aboutArea").value},
    });
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
            $(this).parent().remove();
    });
} 

function cancelAboutMe() {
    $("#aboutChanges").fadeOut(400, function() { 
        $("#btnEditAbout").fadeIn(400);
    });
    document.getElementById("aboutArea").disabled = true;
}

function activateSong() {
    var btn = $(event.target);
    
    if (currentActiveButton == null) {
        currentActiveButton = btn;
        btn.children("img")[0].style.display = "inline";
        btn.toggleClass("active");
    } else {
        currentActiveButton.children("img")[0].style.display = "none";
        currentActiveButton.toggleClass("active");
        
        if (currentActiveButton[0] == btn[0]) {
            currentActiveButton = null;
        } else {
            currentActiveButton = btn;
            btn.children("img")[0].style.display = "inline";
            btn.toggleClass("active");
        }
    }
}

function removeSongs() {
    var btnSongs = $("#songs-list button");
    var btnSpans = $("#songs-list span");
    
    if(currentActiveButton != null) {
        currentActiveButton.children("img")[0].style.display = "none";
        currentActiveButton.toggleClass("active");
        currentActiveButton = null;
    }
    
    for(var i = 0; i < btnSongs.length ; ++i) {
        btnSongs[i].disabled = true;
        btnSpans[i].style.display = "block";
    }
    $("#btnRemoveSong").fadeOut(400, function() {
        $("#btnSaveSong").fadeIn(400);
    });
}

function saveSongs() {
    var btnSongs = $("#songs-list button");
    var btnSpans = $("#songs-list span");
    for(var i = 0; i < btnSongs.length ; ++i) {
        btnSongs[i].disabled = false;
        btnSpans[i].style.display = "none";
    }
    $("#btnSaveSong").fadeOut(400, function() {
        $("#btnRemoveSong").fadeIn(400);
    });
}
