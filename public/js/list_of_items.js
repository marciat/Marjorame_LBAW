'use strict'

let categories_toggler = document.getElementsByClassName("caret");

for (let i = 0; i < categories_toggler.length; i++) {
  categories_toggler[i].addEventListener("click", function() {
    this.parentElement.querySelector(".nested").classList.toggle("active");
    this.classList.toggle("caret_down");
  });
} 

$(function() {
  $( ".favorite_grid" ).click(function(e) {
    $(this).toggleClass( "press", 1000 );
  });
});
