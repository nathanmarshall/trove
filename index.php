<?php session_start();
	if (!isset($_SESSION['logged_in_user'])){
  header('Location: login_form.php');
} else {

 ?>
 	<?php 
 		require_once('includes/functions.php'); 
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
	<?php require_once('aside.php'); ?>
	<?php include_once('header.php'); ?>
	<!-- Include Aside -->


	<!-- Content Wrapper -->
	<div class="content-wrapper">

		<?php

		$currentUser = $_SESSION['logged_in_user'];

		//Post Query 
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
						 ORDER BY postDate DESC";
		//List of events 
		post($userid,$db,$dbconfig,$sql);
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