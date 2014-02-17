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

	<!-- Include Aside -->
	<?php include_once('aside.php'); ?>

	<!-- Content Wrapper -->
	<div class="content-wrapper">
		<!-- Inlude Header -->
	<?php include_once('header.php'); ?>
		<!-- Journal Profile -->
		<div class="user-profile">

			
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