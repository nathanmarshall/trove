<?php session_start();
	require_once('includes/mysql.php');
	require_once('includes/db.php');

	$db = new MySQL($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['database']);
			


	//For commenting
	if(isset($_POST['comment'])){

		$comment = $_POST['comment'];
		$postid = $_POST['post'];
		$userid = $_SESSION['logged_in_user'];
		$now = date('Y-m-d H:i:s');

		$sql = "INSERT INTO comments (comment, commentUserId, commentPostId, commentDate) VALUES (?,?,?,?)";
						
		$stm = $db->dbConn->prepare($sql);

      	$stm->execute(array($comment,
      						$userid,
      						$postid, 
      						$now
      						)); 

      	header('Location: '.$_SERVER['HTTP_REFERER']);
        exit();

	}


	//For geming 
	else if(isset($_POST['gem'])){
		
		if($_GET['gem'] == 'yes'){

		$userid = $_SESSION['logged_in_user'];
		$postid = $_GET['post']; 

		$sql = "INSERT INTO gems (gemPostId, gemUserId) VALUES (?,?)";
						
		$stm = $db->dbConn->prepare($sql);

      	$stm->execute(array($postid, 
      						$userid
      						)); 
    header('Location: '.$_SERVER['HTTP_REFERER']);
          exit();

    } else {

      $userid = $_SESSION['logged_in_user'];
    $postid = $_GET['post']; 

    $sql = "DELETE FROM gems WHERE gemPostId = ? AND GemUserId = ? ";
            
    $stm = $db->dbConn->prepare($sql);

        $stm->execute(array($postid, 
                  $userid
                  )); 
       header('Location: '.$_SERVER['HTTP_REFERER']);
          exit();

    }
	} 


	//For following
	else if(isset($_GET['follow'])){

      //follow
      if($_GET['follow'] == 'yes'){

				$userid = $_GET['user'];

				$relatedUser = $_SESSION['logged_in_user'];

				$inq = "INSERT INTO userRelationship (relatingUserId, relatedUserId, relation) VALUES (?, ?, ?)";
				
				$stm = $db->dbConn->prepare($inq);

				$stm->execute(array($userid,$relatedUser,'following'));

          header('Location: journal.php?user='.$userid);
          exit();
      
      //Unfollow
      } else {

        $userid = $_GET['user'];

        $relatedUser = $_SESSION['logged_in_user'];

        $delq = "DELETE FROM userRelationship WHERE relatingUserId = ? AND relatedUserId = ?";
        
        $stm = $db->dbConn->prepare($delq);

        $stm->execute(array($userid,$relatedUser));

        header('Location: journal.php?user='.$userid);
        exit();

      }

        }
				



?>