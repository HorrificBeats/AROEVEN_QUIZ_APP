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

/* $(document).ready(function () {
  console.log("ready!");
  $("#table_id").DataTable();
  alert("Ready!");
});
 */

/* DATA TABLES ?? */
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
  //if (document.getElementsByClassName("form-check-input").checked) {
    //document.getElementById("Hspinner").style.display = "block";
    //document.getElementById("magicText").style.display = "none";
    document.getElementById('movingButton').classList.add('animate__animated', 'animate__shakeX');;
  //}
};


function RadioValidator() {

}