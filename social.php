<?php session_start();
	require_once('includes/mysql.php');
	require_once('includes/db.php');

	$db = new MySQL($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['database']);

	//For commenting
	if(isset($_POST['comment'])){

		$comment = $_POST['comment'];
		$postid = $_POST['postId'];
		$userid = $_SESSION['logged_in_user'];
		$now = date('Y-m-d H:i:s');
    $message = 'success';

		$sql = "INSERT INTO comments (comment, commentUserId, commentPostId, commentDate) VALUES (?,?,?,?)";

		$stm = $db->dbConn->prepare($sql);

  	$stm->execute(array($comment,
  						$userid,
  						$postid,
  						$now
  						));

    echo json_encode($message);
	}

	//For following
  if(isset($_POST['follow'])){

      //follow
      if($_POST['follow'] == 'follow' ){

				$userid = $_POST['user'];

				$relatedUser = $_SESSION['logged_in_user'];

				$inq = "INSERT INTO userRelationship (relatingUserId, relatedUserId, relation) VALUES (?, ?, ?)";

				$stm = $db->dbConn->prepare($inq);

				$stm->execute(array($userid,$relatedUser,'following'));

        $results = array('follow' => 'following');

        echo json_encode($results);

      //Unfollow
      } else {

        $userid = $_POST['user'];

        $relatedUser = $_SESSION['logged_in_user'];

        $delq = "DELETE FROM userRelationship WHERE relatingUserId = ? AND relatedUserId = ?";

        $stm = $db->dbConn->prepare($delq);

        $stm->execute(array($userid,$relatedUser));

        $results = array('follow' => 'follow');

        echo json_encode($results);

      }
    }
?>