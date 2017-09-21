var $falseHeader = $('.falseHeader');
var $shadower = $('.shadower');
var $fixedHead = $('.fixedHead');
var $menuLi   = $('.menu ul li');
var stickyHeight = $falseHeader.offset().top;

$(window).scroll(function() {
  
  var wScroll = $(this).scrollTop();
  var headScroll = (-wScroll / 2);
  var faderScroll = (wScroll / 400);
  var fadeToColor = Math.min(faderScroll, 1);

  $shadower.css({
    opacity: fadeToColor
  });

  $fixedHead.css({
    backgroundPosition: '50%' + (-215 + headScroll) + 'px'
  });

  if (wScroll >= stickyHeight) {
    $falseHeader.addClass('clipped');
  } else {
    $falseHeader.removeClass('clipped');
  }
 
});


$menuLi.click(function() {
  $menuLi.removeClass('current');
  $(this).addClass('current');
});