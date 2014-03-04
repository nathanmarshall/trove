<?php

function post($userid,$db,$dbconfig,$sql) {

    $stm = $db->dbConn->prepare($sql);

    $stm->execute(array());

    $results = $stm->fetchAll();

    foreach($results as $data){

      $db = new MySQL($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['database']);

      //For gems
      $sql = "SELECT  COUNT(gemId) AS gemNumber FROM gems WHERE gemPostId = ?";

      $stm = $db->dbConn->prepare($sql);

      $stm->execute(array($data['postId']));

      $count = $stm->fetch();

      //Start of a post
      echo '<article class="event">';
      echo "<header>";
      echo '<a href="journal.php?user='.$data['userId'].'"><img class="post-user-pic" src="images/userimages/'.$data['userId'].'/'.$data['userPic'].'"></a>';
      echo '<div class="event-info">';
      echo '<h2>'.$data['postTitle'].'<h2>';
      echo '<a href="journal.php?user='.$data['userId'].'"><h3>by '.$data['userHandle'].'<h3></a>';
      echo '</div>';
      echo "</header>";

      if($data['postPhoto'] != ''){
        echo '<div class="post-image" style=" background-image: url(images/postimages/'.$data['userId'].'/'.$data['postPhoto'].')">';
        echo '<ul class="ls-social"><li><button class="btn-comment" data-post="'.$data['postId'].'"><span class="icon-comment3"></span></button></li><li><button data-post="'.$data['postId'].'" class="btn-gem"><span class="icon-diamond">&nbsp;'.implode($count).'</span></button></li></ul>';
        echo '</div>';
      }

      echo '<div class="posts-inner">';

      /* echo '<p>Posted: '.substr($data['postDate'],0,10).'<p>'; */
      if ($data['postText'] != '') {
        $month = date("M", strtotime($data['postDate']));
        $day = date("jS", strtotime($data['postDate']));
        $year = date("Y", strtotime($data['postDate']));

        echo '<span class="month">'.$month.'</span>';
        echo '<span class="day">'.$day.'</span>';
        echo '<span class="year">'.$year.'</span>';
        echo '<p class="post-text">'.$data['postText'].'<p>';
        echo '</div>';
      }


      //end social container
      echo '</article>';

    }
    //End of a Post
}

//Function for posting

if(isset($_POST['index'])) {
  session_start();
  //Post Query
    require_once('db.php');
    require_once('mysql.php');

    $index = $_POST['index'];
    $currentUser = $_SESSION['logged_in_user'];
    $userid = $_SESSION['logged_in_user'];
    $db = new MySQL($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['database']);
    $sql = "SELECT  postId, postTitle, postDate, postText, posts.userId, postPhoto, users.userHandle, users.userFname, users.userLname,  users.userPic
             FROM posts
             INNER JOIN userRelationship
              ON posts.userId = userRelationship.relatingUserId
             INNER JOIN users
              ON posts.userId = users.userId
             WHERE relatingUserId = posts.userid
              AND userRelationship.relatedUserId  = $currentUser
             UNION ALL SELECT  postId, postTitle, postDate, postText, posts.userId, postPhoto, users.userHandle, users.userFname, users.userLname,  users.userPic
             FROM posts
             INNER JOIN users
             ON posts.userId = users.userId
             WHERE posts.userId = $currentUser
             ORDER BY postDate DESC
             LIMIT $index , 5 ";

  post($userid,$db,$dbconfig,$sql);
}

//Get comments
if(isset($_POST['commentPost'])) {

  require_once('db.php');
  require_once('mysql.php');

  $db = new MySQL($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['database']);
  $commentPost = $_POST['commentPost'];
  $sql = "SELECT comment, users.userId, users.userHandle, users.userPic FROM comments INNER JOIN users ON users.userId = comments.commentUserId WHERE commentPostId = ? ORDER BY commentDate ASC";

  $stm = $db->dbConn->prepare($sql);

  $stm->execute(array($commentPost));

  $results = $stm->fetchAll();

  foreach ($results as $commentdata) {
    echo '<div class="comment">';
    echo '<img src="images/userimages/'.$commentdata['userId'].'/'.$commentdata['userPic'].'">';

    echo '<a href="journal.php?user='.$commentdata['userId'].'"><span>'.$commentdata['userHandle'].'</span></a>';
    echo '<p class="user-comment">'.$commentdata['comment'].'</p>';
    echo '</div>';
    echo '</div>';
  }
}

?>