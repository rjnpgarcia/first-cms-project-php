$(document).ready(function () {
  $("#summernote").summernote({
    height: 200,
  });
});

$(document).ready(function () {
  $("#selectAllBoxes").click(function () {
    if (this.checked) {
      $(".checkBoxes").each(function () {
        this.checked = true;
      });
    } else {
      $(".checkBoxes").each(function () {
        this.checked = false;
      });
    }
  });
  var div_box = "<div id='load-screen'><div id='loading'></div></div>";

  $("body").prepend(div_box);

  $("#load-screen")
    .delay(400)
    .fadeOut(300, function () {
      $(this).remove();
    });
});

function loadUserOnline() {
  $.get("../admin/includes/functions.php?onlineusers=result", function (data) {
    $(".usersonline").text(data);
  });
}

setInterval(function () {
  loadUserOnline();
}, 2000);
