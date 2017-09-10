/*
*used for making the navbar stick to the page 
*when scrolled past a fixed length 
*/
// note to self: $(var) is shorthand for... 
// document.getElementByID(var)
// ...in a very VERY basic sense 
$(document).ready(function() {
	//TODO: make this transition nicer
  $(window).scroll(function () {
      console.log($(window).scrollTop())
	  
    if ($(window).scrollTop() > 56) {
	  document.getElementsByClassName("topnav")[0].style.top = "0";
	  document.getElementsByClassName("topnav")[0].style.position = "fixed";
    }
    if ($(window).scrollTop() < 56) {
      $('#myTopnav').removeClass('navbar-fixed');
    }
	//change text color 
	//maybe find a better way to do this...
	if ($(window).scrollTop() >= 1485) {
      document.getElementsByClassName("topnav")[0].style.background = "black"
    }
	if ($(window).scrollTop() < 1485 || $(window).scrollTop() >= 2014 ) {
      document.getElementsByClassName("topnav")[0].style.background = "none";
	}
	
  });
});