<?php 
  session_start();
  //For geming 
  require_once('includes/mysql.php');
  require_once('includes/db.php');

  $db = new MySQL($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['database']);
  $userid = $_SESSION['logged_in_user'];
  $postid = $_POST['postId']; 
  $gemExists = false;
  
  if(isset($_POST['gem'])){

    $sql = "SELECT gemId FROM gems WHERE gemPostId = ? AND gemUserId = ?";

    $stm = $db->dbConn->prepare($sql);
     
    $stm->execute(array($postid,$userid)); 

    $results = $stm->fetchAll();

    //Add Gem
    if(empty($results)){

      $sql = "INSERT INTO gems (gemPostId, gemUserId) VALUES (?,?)";
              
      $stm = $db->dbConn->prepare($sql);
     
      $stm->execute(array($postid,$userid)); 

    //Remove Gem
    } else {

      $sql = "DELETE FROM gems WHERE gemPostId = ? AND GemUserId = ? ";
              
      $stm = $db->dbConn->prepare($sql);

      $stm->execute(array($postid, $userid));
    }

  //Get Number of gems

    $sql = "SELECT count(gemId) AS gems FROM gems WHERE gemPostId = ? AND gemUserId = ?";

    $stm = $db->dbConn->prepare($sql);
   
    $stm->execute(array($postid,$userid));

    $results = $stm->fetch();

    echo json_encode($results);
  }

  ?>