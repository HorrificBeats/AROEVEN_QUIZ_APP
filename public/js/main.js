/* Page SPLITTING w/ JS */
  // Uses: elem+ID; slides+CLASS; display:block;
  function showSlide(elementID) {
    var elem = document.getElementById(elementID);
    if (!elem) {
      alert("No slides found.");
      //window.location = "{{ path('module', {'id' : 2}) }}";
      return;
    }
    var slides = document.getElementsByClassName("slide");
    for (var i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
      slides[i].classList.add("animate__animated", "animate__fadeIn");
    }
    elem.style.display = "block";
  }

/* DATA TABLES Options */
$(document).ready(function () {
  $("#table_id").DataTable({
    searching: false,           //Disable Search
    responsive: true,           //Enable reponsive + Breakpoints
    pagingType: "simple",       //Only show Prev/Next btns
    pageLength: 15,             //Default pageLenght
    orderClasses: true,         //Highlight Ordered Column
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


/* Adding loader on QUIZ Button */
function loadingButton() {
  document
    .getElementById("movingButton")
    .classList.add("animate__animated", "animate__swing");
}

function RadioValidator() {}

/* function display() {  
  var checkRadio = document.querySelector( 
      'input[name="quiz_form[answer]"]:checked'); 
    
  if(checkRadio != null) { 
      //document.getElementById("disp").innerHTML = checkRadio.value + " radio button checked"; 
      document.getElementById('movingButton').classList.add('animate__animated', 'animate__shakeX');
  } 
  else { 
      //document.getElementById("disp").innerHTML = "No one selected"; 
      document.getElementById("Hspinner").style.display = "block";
      document.getElementById("magicText").style.display = "none";
  } 
}  */

function logoAnimation() {
  document
    .getElementById("logo")
    .classList.add("animate__animated", "animate__swing");
}
