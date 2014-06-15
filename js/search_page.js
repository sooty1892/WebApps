$(document).ready(function() {
    $("span.close").click(function () {
          $(this).parent().fadeOut(400, function() {
              $(this).parent().remove();
          });
    });
})

function showFiltering() {
    $("#allResults").attr("checked", false);
    $("#filterAdding").fadeIn(400);
}

function hideFiltering() {
    $("#filterAdding").fadeOut(400);
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
}