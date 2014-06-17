var currentActiveButton = null;
var currentActiveAudio = null;

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

function followUser() {
    if($("#btnFollow").val() == "not_following"){
        $("#btnFollow").html('<i class="glyphicon glyphicon-ok"></i> Following');
        $("#btnFollow").val("following");
        $("#btnFollow").css("opacity", "0.6");
    } else {
        $("#btnFollow").html('<i class="glyphicon glyphicon-user"></i> Follow');
        $("#btnFollow").val("not_following");
        $("#btnFollow").css("opacity", "1");
    }
}

function fileNamesList() {
    var inp = $("#songFiles")[0];
    for (var i = 0; i < inp.files.length; ++i) {
        var name = inp.files.item(i).name;
        $("#song-preview-list").append('<div class="song-entry">' + name + 
            ' <i style="float:right; color:#2ecc71" class="glyphicon glyphicon-ok"></i></div><br>');
    }
}

function cancelUser() {
    $("#btnsChanges").fadeToggle(400, function() { 
        $("#btnEdit").fadeToggle(400);
    });
    $("#files").empty();
    $("#progress .progress-bar").css("width","0%");
    document.getElementById("userRealName").disabled = true;
}

function updateOutputSelection() {
    var filePath = $("#FileInput").val();
    $("#output").html(filePath.substring(filePath.lastIndexOf("\\") + 1, 
        filePath.length));
}

function saveChangesUser(username) {
    $("#btnsChanges").fadeToggle(400, function() { 
        $("#btnEdit").fadeToggle(400);
    });
    // $("#files").empty();
    // $("#progress .progress-bar").css("width","0%");
    document.getElementById("userRealName").disabled = true;
    $.ajax({
        type: 'POST',
        url: "scripts/save_name.php",
        data: { username: username,
                name: document.getElementById("userRealName").value},
    });
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
        url: "scripts/save_about.php",
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

function cancelSkills(username) {
    var btnSkills = $("#skill-list button");
    var btnSpans = $("#skill-list span");

    var skills = "";
    
    for(var i = 0; i < btnSkills.length ; ++i) {
        btnSkills[i].disabled = false;
        skills = skills + "," + btnSkills[i].value;
        btnSpans[i].style.display = "none";
    }
    
    $("#btnsSkillEdits").fadeOut(300, function() { 
        $("#btnEditSkills").fadeIn(300);
    });

    $.ajax({
        type: 'POST',
        url: "scripts/save_skills.php",
        data: { username: username,
                skills: skills},
    });
}

function addSkills() {
    var newSkill = $("#skillField").val();
    if (newSkill != "") {
        $("#skill-list").append("\n<li><button type=\"button\" class=\"btn-primary\" value=\"" + newSkill + "\" disabled>" 
                               + newSkill + "<span class=\"close\" style =\"display: block\">x</span></button></li>");;
        $("#skillField").val("");
        $(document).on("click", "span.close", buttonFade);
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

var activate = function activateSong() {
    var btn = $(event.target);
    var id = btn.attr('id');

    if (currentActiveButton == null) {
        currentActiveButton = btn;
        currentActiveAudio = document.getElementById("audio" + id);
        currentActiveAudio.play();       
        btn.children("img")[0].style.display = "inline";
        btn.toggleClass("active");
    } else {
        currentActiveButton.children("img")[0].style.display = "none";
        currentActiveButton.toggleClass("active");
        currentActiveAudio.load();
        
        if (currentActiveButton[0] == btn[0]) {
            currentActiveAudio = null;
            currentActiveButton = null;
        } else {
            currentActiveButton = btn;
            currentActiveAudio = document.getElementById("audio" + id);
            currentActiveAudio.play();  
            btn.children("img")[0].style.display = "inline";
            btn.toggleClass("active");
        }
    }
}

$('.feed-element').hover(function(){
    alert("");
});
