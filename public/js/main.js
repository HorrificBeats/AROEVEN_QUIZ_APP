/* Page SPLITTING w/ JS */
// Uses: elem+ID; slides+CLASS; display:block;
function showSlide(elementID) {
  var elem = document.getElementById(elementID);
  //elementID will be replaced with a TWIG variable, containing the Slide Content

  if (!elem) {
    alert("No slides found.");
    return;
  }
  //Creates object with all slides
  var slides = document.getElementsByClassName("slide");

  //Adds 'display:none' to all slides
  for (var i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
    slides[i].classList.add("animate__animated", "animate__fadeIn");
  }
  //Adds 'd:block' one-by-one to each slide
  elem.style.display = "block";

  // Timed-hidding of NextSlide Button (ignores the 1st slide)
  $(".NextSlideTimer").removeClass("animate__flipInX");
  $(".NextSlideTimer").addClass("invisible");
  setTimeout(function () {
    $(".NextSlideTimer").removeClass("invisible");
    $(".NextSlideTimer").addClass("animate__flipInX");
  }, 500);
}

// 1st Slide Timed Button Hidding
window.onload = function () {
  setTimeout(function () {
    $(".NextSlideTimer").removeClass("invisible");
    $(".NextSlideTimer").addClass("animate__flipInX");
  }, 500);
};



/* DATA TABLES Options */
$(document).ready(function () {
  $("#table_id").DataTable({
    searching: false, //Disable Search
    responsive: true, //Enable reponsive + Breakpoints
    pagingType: "simple", //Only show Prev/Next btns
    pageLength: 15, //Default pageLenght
    orderClasses: true, //Highlight Ordered Column
    select: true,
    columnDefs: [
      { responsivePriority: 1, targets: 0 },
      { responsivePriority: 2, targets: -1 },
    ],
  });

  $('a[data-toggle="tab"]').on("shown.bs.tab", function (e) {
    $($.fn.dataTable.tables(true))
      .DataTable()
      .columns.adjust()
      .responsive.recalc();
  });
});

/* OnClick function to move QUIZ Button */
/* function movingButton() {
  document
    .getElementById("movingButton")
    .classList.add("animate__animated", "animate__bounce");
} */
