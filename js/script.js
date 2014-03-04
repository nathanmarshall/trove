//Script.js

//Jquery Wrapper
$(function(){

	//Show menu
	$('.hamburger').click(function(e){
    e.preventDefault();
		$('.content-wrapper').toggleClass('slide');
	});

  //Hide Menu
  //$('.content-wrapper').click(function(e){
   // $('.content-wrapper').removeClass('slide');
  //  $('.logo').removeClass('slide');
 // });

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

  //Following
  $('.btn-follow').on('click', function(e){
    e.preventDefault();

    //var this = $(this);
    var url = "../trove/social.php";
    var user = $(this).data('user');
    var fo = $(this).attr('data-follow');
    var data = { follow: fo, user: user };
    console.log(fo);

    $.ajax({
      url: url,
      type: 'POST',
      dataType: 'json',
      data: data,
      success: function(data){
        console.log(data.follow);
        if (data.follow == 'following') {
          console.log(data.follow);
          $('.btn-follow').addClass('following');
          $('.btn-follow').attr('data-follow', 'following');
        } else {
          console.log(data.follow);
          $('.btn-follow').removeClass('following');
          $('.btn-follow').attr('data-follow', 'follow');
        }
      },
      error: function(data){
        console.log('AJAX failed');
        }
    });
  });

  //view comments
  var dataPost;
  $('.btn-comment').click(function(){
    $('.comments').toggleClass('slide');
    $('.content-wrapper').toggleClass('comment-slide');

    dataPost = $(this).data('post');
    var data = { commentPost: dataPost };
    renderComments(data);
  });

  function renderComments(data2) {

    var url = "../trove/includes/functions.php";
    var data2 = { commentPost: dataPost };

    $.ajax({
      url: url,
      type: 'POST',
      dataType: 'html',
      data: data2,
      success: function(data){
        $('.comment-list').html(data);
        console.log('hello');
      },
      error: function(data){
        console.log('AJAX failed');
        }
    });
  }

  //Post comment
  $(document).on('submit', '.comment-form', function(event){
    event.preventDefault();

    var comment = $('.comment-form input').val();
    var url = "../trove/social.php";
    var data = {
      postId: dataPost,
      comment: comment
    };

    $.ajax({
      url: url,
      type: 'POST',
      dataType: 'json',
      data: data,
      success: function(){
        renderComments(dataPost);
      },
      error: function(){
        console.log('AJAX failed');
      }
    });
  });

   //Following

  var index = 0;

  $(window).on('scroll', function(e){

    if($(window).scrollTop() + $(window).height() == $(document).height()) {

      index += 5;
      console.log(index);

      //var this = $(this);
      var url = "../trove/includes/functions.php";
      var data = { index: index };

      $.ajax({
        url: url,
        type: 'POST',
        dataType: 'html',
        data: data,
        success: function(data){
          console.log('sucsess');
          $('.content-wrapper').append(data);
        },
        error: function(data){
          console.log('AJAX failed');
          }
      });
    }
  });
});