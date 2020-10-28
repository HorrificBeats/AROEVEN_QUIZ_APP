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
    slides[i].style.display = "none"; /* .animated .bounce */
    //document.getElementById('SlidesContainer').classList.add('animate__animated', 'animate__bounceInLeft');
    slides[i].classList.add("animate__animated", "animate__fadeIn");

    /* TODO: show Button on LAST Slide */
    if (i == slides.lenght) {
      document.getElementById("SlidesContainer").style.display = "none";
    }
  }
  elem.style.display = "block";
}

/* DATA TABLES */

$(document).ready(function () {
  $("#table_id").DataTable({
    //Disable Search
    searching: false,
    //Enable reponsive + Breakpoints
    responsive: true,
    /* responsive: {
      breakpoints: [
        { name: "desktop", width: 1200 },
        { name: "tablet", width: 992 },
        { name: "fablet", width: 768 },
        { name: "phone", width: 576 }
      ],
    }, */
    //Only show Prev/Next btns
    pagingType: "simple",
    //Default pageLenght
    pageLength: 15,

    //paging: false,
    orderClasses: true, //Highlight Ordered Column
    select: true,
    columnDefs: [
      { responsivePriority: 1, targets: 0 },
      { responsivePriority: 2, targets: -1 }
  ]
  });

  $('a[data-toggle="tab"]').on("shown.bs.tab", function (e) {
    $($.fn.dataTable.tables(true))
      .DataTable()
      .columns.adjust()
      .responsive.recalc();
      
  });
});

/* MOVING LETTERS (TBDeleted) */
// Wrap every letter in a span
window.onload = function () {
  /*   if (!doneTheStuff){ */
  var textWrapper = document.querySelector(".ml1 .letters");
  textWrapper.innerHTML = textWrapper.textContent.replace(
    /\S/g,
    "<span class='letter'>$&</span>"
  );

  anime
    .timeline({ loop: true })
    .add({
      targets: ".ml1 .letter",
      scale: [0.3, 1],
      opacity: [0, 1],
      translateZ: 0,
      easing: "easeOutExpo",
      duration: 600,
      delay: (el, i) => 70 * (i + 1),
    })
    .add({
      targets: ".ml1 .line",
      scaleX: [0, 1],
      opacity: [0.5, 1],
      easing: "easeOutExpo",
      duration: 700,
      offset: "-=875",
      delay: (el, i, l) => 80 * (l - i),
    })
    .add({
      targets: ".ml1",
      opacity: 0,
      duration: 1000,
      easing: "easeOutExpo",
      delay: 1000,
    });
  doneTheStuff = true;
  // do the stuff
  /*   } */
};

/* Adding loader on QUIZ Button */
function loadingButton() {
  document.getElementById("movingButton").classList.add("animate__animated", "animate__swing");
  //if (document.getElementsByClassName("form-check-input").checked == true) {
  //if (document.querySelectorAll('[id^="quiz_form_answer_"]').checked) {
  //document.getElementById("Hspinner").style.display = "block";
  //document.getElementById("magicText").style.display = "none";
  //} else {
  //document.getElementById('movingButton').classList.add('animate__animated', 'animate__shakeX');
  //}
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
  document.getElementById("logo").classList.add("animate__animated", "animate__swing");
}