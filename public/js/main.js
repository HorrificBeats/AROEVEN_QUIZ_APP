/* Page SPLITTING w/ JS */
// Uses: elem+ID; slides+CLASS; display:block;
function showSlide(elementID) {
  var elem = document.getElementById(elementID);
  if (!elem) {
    //alert("No slides found.")
    //window.location = "{{ path('module', {'id' : 2}) }}";
    return;
  }
  var slides = document.getElementsByClassName("slide");
  for (var i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  elem.style.display = "block";
}

/* $(document).ready(function () {
  console.log("ready!");
  $("#table_id").DataTable();
  alert("Ready!");
});
 */
window.onload = function () {
  if (window.jQuery) {
    // jQuery is loaded
    //alert("Yeah!");
    $("#table_id").DataTable();
  } else {
    // jQuery is not loaded
    alert("Doesn't Work");
  }
};

$(document).ready(function () {
  $("#table_id").DataTable();
});
