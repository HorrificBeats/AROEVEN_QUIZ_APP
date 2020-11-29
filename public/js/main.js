/* Page SPLITTING w/ JS */
// Uses: elem+ID; slides+CLASS; display:block;
function showSlide(elementID) {
  var elem = document.getElementById(elementID);
  //elementID will be replaced with a TWIG variable, containing the Slide Content
  if (!elem) {
    alert("No slides found.");
    return;
  }
  //Creates array with all <div id='Slide'> 
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
    order: [[ 0, "desc" ]],
    searching: false, //Disable Search
    responsive: true, //Enable reponsive + Breakpoints
    pagingType: "simple", //Only show Prev/Next btns
   pageLength: 25, //Default pageLenght
    orderClasses: true, //Highlight Ordered Column
    select: true,
    columnDefs: [
      { responsivePriority: 1, targets: 0 },
      { responsivePriority: 2, targets: -1 },
      {
        "targets": [ 0 ],
        "visible": false,
        "searchable": false
    },
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

// Contact BTN
function clickedBTN() {
  var btnL = document.getElementById('contactBtnLarge');
  var btnS = document.getElementById('contactBTN');
  
  if (btnL.classList.contains('btn-secondary')) {
    btnL.classList.remove('btn-secondary');
    btnL.classList.add('btn-dark');
  }else {
    btnL.classList.remove('btn-dark');
    btnL.classList.add('btn-secondary');
  }

  if (btnS.classList.contains('btn-secondary')) {
    btnS.classList.remove('btn-secondary');
    btnS.classList.add('btn-dark');
  }else {
    btnS.classList.remove('btn-dark');
    btnS.classList.add('btn-secondary');
  }
}
