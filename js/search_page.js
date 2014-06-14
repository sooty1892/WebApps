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