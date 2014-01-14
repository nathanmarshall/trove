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
	$('.hamburger').click(function(){
		
		$('.content-wrapper').toggleClass('slide');
		$('header.main-header').toggleClass('slide');
	});
	
	
	
});