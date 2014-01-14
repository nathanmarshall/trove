<?php session_start();
	if (!isset($_SESSION['logged_in_user'])){
  header('Location: login_form.php');
} else {

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

		<?php



		$currentUser = $_SESSION['logged_in_user'];

		$selq = "SELECT  postId, postTitle, postDate, postText, posts.userId, postPhoto, users.userHandle, users.userFname, users.userLname,  users.userPic FROM posts INNER JOIN userRelationship ON posts.userId = userRelationship.relatingUserId
		INNER JOIN users ON posts.userId = users.userId WHERE relatingUserId = posts.userid AND userRelationship.relatedUserId  = $currentUser UNION ALL SELECT  postId, postTitle, postDate, postText, posts.userId, postPhoto, users.userHandle, users.userFname, users.userLname,  users.userPic FROM posts INNER JOIN users ON posts.userId = users.userId WHERE 
		posts.userId = $currentUser ORDER BY postDate DESC";

			//Back Up Code (NO PDO)
		$link = mysql_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password']) or die('Connection failed - '.mysql_error());

			//connection is OK, select the DB to work with
		mysql_query("USE nathanmc_trove") or die("$dbName is not found = ".mysql_error());

		$rsselect = mysql_query($selq)or die(mysql_error());


		while ( $data = mysql_fetch_array($rsselect, MYSQL_ASSOC)){

			$db = new MySQL($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['database']);

				//For gems 
			$sql = "SELECT  COUNT(gemId) AS gemNumber FROM gems WHERE gemPostId = ?";

			$stm = $db->dbConn->prepare($sql);

			$stm->execute(array($data['postId']));

			$results = $stm->fetch();

				//For comments

			$csql = "SELECT comment, users.userId, users.userHandle FROM comments INNER JOIN users ON users.userId = comments.commentUserId WHERE commentPostId = ? ORDER BY commentDate ASC ";

			$cstm = $db->dbConn->prepare($csql);

			$cstm->execute(array($data['postId']));

			$cresults = $cstm->fetchAll();

			//Start of a post
			echo '<article class="event">';
			echo "<header>";
			echo '<a href="journal.php?user='.$data['userId'].'"><img class="post-user-pic" src="images/userimages/'.$data['userId'].'/'.$data['userPic'].'"></a>';
			echo '<div class="event-info">';
			echo '<h2>'.$data['postTitle'].'</h2>';
			echo '<a href="journal.php?user='.$data['userId'].'"><h3>by '.$data['userHandle'].'</h3></a>';
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
//End logged_in_user check
include_once('footer.php'); ?>



<!-- Start Event 
			<article class="event">
				
			<img src="images/event.jpg" >
			<p> Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec.</p>
			
			
			</article>
			 End Event -->