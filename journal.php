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
<?php require_once('includes/functions.php'); ?>

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
		//the events
		$sql = "SELECT postId, postDate, postTitle, postText, posts.userId, postPhoto, users.userPic, users.userHandle, users.userFname, users.userLname 
						FROM posts 
						INNER JOIN users 
							ON posts.userId = users.userId 
							WHERE posts.userId = $userid 
    					ORDER BY postDate DESC ";

		post($userid,$db,$dbconfig,$sql);
		?>

</div>
<!-- End Content Wrapper -->
</div>
<!-- End Wrapper -->
<!-- Include Footer -->
<?php 
}
include_once('footer.php'); ?>