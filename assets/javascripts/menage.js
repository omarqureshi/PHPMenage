$(document).ready(function() {
  $("a.close").click(function(e) {
    $(this).parent().remove();
    e.preventDefault();
  })
})