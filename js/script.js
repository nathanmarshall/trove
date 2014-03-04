//Script.js

//Jquery Wrapper
$(function(){

	//Show menu
	$('.hamburger').click(function(e){
    e.preventDefault();
		$('.content-wrapper').toggleClass('slide');
    $('aside').toggleClass('slide');
	});

  //Hide Menu
  //$('.content-wrapper').click(function(e){
   // $('.content-wrapper').removeClass('slide');
  //  $('.logo').removeClass('slide');
 // });

  //AJAX social
  //Gemming
  $('.btn-gem').click(function(e){
    e.preventDefault();

    var url = '../trove/gem.php';
    var postId = $(this).data('post');
    var data = { gem: 'true', postId: postId };
    var $scope = $(this);

    $.ajax({
      url: url,
      type: 'POST',
      dataType: 'json',
      data: data,
      success: function(data){
        if (data.is_gemed) {
          $scope.addClass('gemed');
        } else {
          $scope.removeClass('gemed');
        }

        $scope.children('.icon-diamond').html('&nbsp;' + data.gems.gems);
        console.log(data.is_gemed, data.gems.gems);
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
    var data = { commentPost: dataPost };


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

  $('.icon-close').click(function(){
    $('.comments').removeClass('slide');
    $('.content-wrapper').removeClass('comment-slide');
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