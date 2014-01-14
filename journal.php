<?php session_start(); 
if (!isset($_SESSION['logged_in_user'])){
  header('Location: login_form.php');
} else {
	//includes
require_once 'includes/mysql.php';
require_once 'includes/db.php';
?>
<!-- Include Head -->
<?php include_once('head.php'); ?>
<!-- Add form -->
<?php require_once('add_form.php'); ?>

<!-- Wrapper Start -->
<div class="wrapper">
	
	<!-- Inlude Header -->
	<?php include_once('header.php'); ?>

	<!-- Include Aside -->
	<?php include_once('aside.php'); ?>

	
	<!-- Content Wrapper -->
	<div class="content-wrapper">

		<!-- Journal Profile -->
		<div class="user-profile">

			<?php 

		//Establish User 
			$userid = $_GET['user'];

			$db = new MySQL($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['database']);

		//Get user Info 
			$sql = "SELECT userId, userFname, userLname, userHandle, userPic FROM users WHERE userId = ?";

			$stm = $db->dbConn->prepare($sql);

			$stm->execute(array($userid));

			$results = $stm->fetch();



			echo '<img width="100px" style="border-radius: 50px" height="100px" src="images/userimages/'.$results['userId'].'/'.$results['userPic'].'">';
			echo '<h1>'.$results['userHandle'].'</h1>';
			echo '<h2>'.$results['userFname'].' '.$results['userLname'].'</h2>';
		


			//Follow user 
			if( $userid != $_SESSION['logged_in_user']){

				$logged_in_user = $_SESSION['logged_in_user'];


				//Checks for matching rows 
				$sql = "SELECT count(*) AS relationNumber FROM userRelationship WHERE relatedUserId = ? AND relatingUserId = ?";

				$stm = $db->dbConn->prepare($sql);

				$stm->execute(array($logged_in_user, $userid));

				$match_results = $stm->fetch();

				if ($match_results['relationNumber'] == 0){	
					echo '<a href="social.php?user='.$userid.'&follow=yes" ><h2>Follow</h2></a>';
					echo "<br><br><br>";
				} else {
					echo '<a href="social.php?user='.$userid.'&follow=no"><h2>Unfollow</h2></a>';
					echo "<br><br><br>";
				}
			}


			?>
		</div>
		<!-- End journal profile -->
		

		<?php

			// Php for listting events 

		$sql = "SELECT postId, postDate, postTitle, postText, posts.userId, postPhoto, users.userPic, users.userHandle, users.userFname, users.userLname  FROM posts INNER JOIN users ON posts.userId = users.userId WHERE posts.userId = $userid 
		ORDER BY postDate DESC ";

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
			echo "<header>";
			echo '<a href="journal.php?user='.$data['userId'].'"><img class="post-user-pic" src="images/userimages/'.$data['userId'].'/'.$data['userPic'].'"></a>';
			echo '<div class="event-info">';
			echo '<h2>'.$data['postTitle'].'<h2>';
			echo '<a href="journal.php?user='.$data['userId'].'"><h3>by '.$data['userHandle'].'<h3></a>';
			echo '</div>';
			echo "</header>";
			if($data['postPhoto'] != ''){
				echo '<img class="post-image" src="images/postimages/'.$data['userId'].'/'.$data['postPhoto'].'">';
			}
			echo '<p>Posted: '.substr($data['postDate'],0,10).'<p>';
			echo '<p>'.$data['postText'].'<p>';


				//Gems 

			$logged_in_user = $_SESSION['logged_in_user'];

			$gemPostId = $data['postId'];
			$gemUserId = $_SESSION['logged_in_user'];

			$sql = "SELECT count(gemId) AS gems FROM gems WHERE gemPostId = ? AND gemUserId = ?";

			$stm = $db->dbConn->prepare($sql);

			$stm->execute(array($gemPostId, $gemUserId));

			$match_results = $stm->fetch();

			//social container

			if ($match_results['gems'] == 0){	
				echo '<form class="gem" action="social.php?gem=yes&post='.$data['postId'].'" method="post"><button type="submit" class="gem-button" value="gem" name="gem">+ <span class="icon-diamond"></span></button>'.$results['gemNumber'].' Gem(s)</form>';
			} else {
				echo '<form class="gem" action="social.php?gem=delete&post='.$data['postId'].'" method="post"><button type="submit" class="gem-button"  value="gem" name="gem">- <span class="icon-diamond"></span></button>'.$results['gemNumber'].' Gem(s)</form>';
			}

		
		foreach ($cresults as $commentdata) {
			echo '<p class="user-comment"><span class="icon-chat"></span><a href="journal.php?user='.$commentdata['userId'].'"><span>'.$commentdata['userHandle'].'</span></a> '.$commentdata['comment'].'</p>';
		}

			echo '<form class="new-comment" action="social.php?action=comment" method="post">
			<input type="hidden" name="post" value="'.$data['postId'].'">
			<input placeholder="Your comment" class="comment-field" type="text" name="comment" id="comment">
			</form>
			<br>';

	
			//end social container
			echo '</article>';
			
		}
		//End of a Post



	?>
</div>
<!-- End Content Wrapper -->


</div>
<!-- End Wrapper -->


<!-- Include Footer -->
<?php 
}
include_once('footer.php'); ?>