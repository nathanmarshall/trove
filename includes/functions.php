<?php 

//Function for posting
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

      $results = $stm->fetch();

        //For comments
  
      $csql = "SELECT comment, users.userId, users.userHandle FROM comments INNER JOIN users ON users.userId = comments.commentUserId WHERE commentPostId = ? ORDER BY commentDate ASC";

      $cstm = $db->dbConn->prepare($csql);

      $cstm->execute(array($data['postId']));

      $cresults = $cstm->fetchAll();

      //Start of a post
      echo '<article class="event">';
      if($data['postPhoto'] != ''){
        echo '<div class="post-image" style=" background-image: url(images/postimages/'.$data['userId'].'/'.$data['postPhoto'].')">';
        echo "<header>";
        echo '<a href="journal.php?user='.$data['userId'].'"><img class="post-user-pic" src="images/userimages/'.$data['userId'].'/'.$data['userPic'].'"></a>';
        echo '<div class="event-info">';
        echo '<h2>'.$data['postTitle'].'<h2>';
        echo '<a href="journal.php?user='.$data['userId'].'"><h3>by '.$data['userHandle'].'<h3></a>';
        echo '</div>';
        echo "</header>";
        echo '</div>';
      }
      echo '<div class="posts-inner">';
      /* echo '<p>Posted: '.substr($data['postDate'],0,10).'<p>'; */
      echo '<p class="post-text">'.$data['postText'].'<p>';
      echo '</div>';


        //Gems 
        /* 
      $logged_in_user = $_SESSION['logged_in_user'];

      $gemPostId = $data['postId'];
      $gemUserId = $_SESSION['logged_in_user'];

      $sql = "SELECT count(gemId) AS gems FROM gems WHERE gemPostId = ? AND gemUserId = ?";

      $stm = $db->dbConn->prepare($sql);

      $stm->execute(array($gemPostId, $gemUserId));

      $match_results = $stm->fetch();

      //social container
      echo '<form class="gem" data-post="'.$data['postId'].'" action="gem.php" method="post"><button type="submit" class="gem-button" value="gem" name="gem">+ <span class="icon-diamond"></span></button><span class="gem-number">'.$results['gemNumber'].' </span>Gem(s)</form>';
    
    
    foreach ($cresults as $commentdata) {
      echo '<p class="user-comment"><span class="icon-chat"></span><a href="journal.php?user='.$commentdata['userId'].'"><span>'.$commentdata['userHandle'].'</span></a> '.$commentdata['comment'].'</p>';
    }

      echo '<form class="new-comment" action="social.php?action=comment" method="post">
      <input type="hidden" name="post" value="'.$data['postId'].'">
      <input placeholder="Your comment" class="comment-field" type="text" name="comment" id="comment">
      </form>
      <br>';
    */
  
      //end social container
      echo '</article>';
      
    }
    //End of a Post
}
?>