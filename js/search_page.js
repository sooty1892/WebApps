$(document).ready(function() {
    $("span.close").click(function () {
          $(this).parent().fadeOut(400, function() {
              $(this).parent().remove();
          });
    });
})

$(document).ready(function() {
  $('#filterProject').keyup(function(e) {
    if (e.keyCode == 13) {
      $('#skills-genre-list').append($("\n<li><div class=\"tag\" value=\"" + $('#filterProject').val() + "\">" + $('#filterProject').val() + "<span class=\"close\">x</span></div></li>"));
      $('#filterProject').val('');
    }
    $(document).on("click", "span.close", buttonRemove);
  });

  $('#filterUser').keyup(function(e) {
    if (e.keyCode == 13) {
      $('#skills-list').append($("\n<li><div class=\"tag\" value=\"" + $('#filterUser').val() + "\">" + $('#filterUser').val() + "<span class=\"close\">x</span></div></li>"));
      $('#filterUser').val('');
    }
    $(document).on("click", "span.close", buttonRemove);
  });
})

var buttonRemove = function(){
  $(this).parent().fadeOut(400, function() {
    $(this).parent().remove();
  });
}

function hideFiltering() {
    $("#filterAddingProject").fadeOut(400);
    $("#filterAddingUser").fadeOut(400);
    $("#projects").attr("checked", false);
    $("#users").attr("checked", false);
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
    getAllData();
}

function showFilteringProject() {
  $('#skills-genre-list').empty();
  $("#allResults").attr("checked", false);
  $('#filterProject').val("");
  $("#filterAddingUser").fadeOut(0);
  $("#filterAddingProject").fadeIn(400);
  getProjectData();
}

function showFilteringUser() {
  $('#skills-list').empty();
  $("#allResults").attr("checked", false);
  $('#filterUser').val("");
  $("#filterAddingProject").fadeOut(0);
  $("#filterAddingUser").fadeIn(400);
  getUserData();
}