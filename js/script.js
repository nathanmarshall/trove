//Script.js


//Show overlay

$(function(){


  //Show overlay

  $('.overlay').hide();
  $(".add-ico").click(function(){
    $('.overlay').toggle();
    $('.add-ico').toggleClass('close_add');
    $('.main-header').toggleClass('toggle-header');
    $('aside').toggleClass('hide');
  });


	//Slide out menu 
	$('.hamburger').click(function(e){
    e.preventDefault();
		$('.content-wrapper').toggleClass('slide');
    $('.logo').toggleClass('slide');
	});

  $('.content-wrapper').click(function(e){
    e.preventDefault();
    $('.content-wrapper').removeClass('slide');
    $('.logo').removeClass('slide');
  });


});