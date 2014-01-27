//Script.js

//Jquery Wrapper 
$(function(){

	//Show menu
	$('.hamburger').click(function(e){
    e.preventDefault();
		$('.content-wrapper').toggleClass('slide');
    $('.logo').toggleClass('slide');
	});

  //Hide Menu 
  $('.content-wrapper').click(function(e){
    $('.content-wrapper').removeClass('slide');
    $('.logo').removeClass('slide');
  });

  //AJAX social
  //Gemming
  $('.gem-button').click(function(e){
    e.preventDefault();

    var url = $(this).parent().attr('action');
    var postId = $(this).parent().data('post');
    var data = { gem: 'true', postId: postId };

    $.ajax({
      url: url,
      type: 'POST',
      dataType: 'json',
      data: data,
      success: function(data){
        $('span.gem-number').html(data.gems);
        console.log(data.gems);
      },
      error: function(data){
        console.log('AJAX failed');
      }
    });
    });
  });
