<?php
session_start();
//Required Files
require_once('includes/mysql.php');
require_once('includes/db.php');

//Gets Current Time
$current_time = date("Y-m-d");
$current_user = $_SESSION['logged_in_user'];

$db = new MySQL($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['database']);

$sql = "SELECT count(postDate) AS postsToday FROM posts WHERE userId = ? AND postDate LIKE '$current_time%'";

$stm = $db->dbConn->prepare($sql);

$stm->execute(array($current_user));

$results = $stm->fetch();

?>
	<!-- Add form overlay -->
<!-- Include Head -->
<?php
include_once('head.php');
// require_once('includes/functions.php');
?>

<!-- Wrapper Start -->
<div class="wrapper">
<?php require_once('aside.php'); ?>
<div class="content-wrapper">
<?php require_once('header.php'); ?>

<?php

			//If user HASN'T posted today
if ($results['postsToday'] == 0){
?>

<!-- Wrapper Start -->
<div class="add-wrapper">

	<!-- Login Form -->
	<form class="add" enctype="multipart/form-data" action="add.php" method="post">
		<input type="file" name="picture" id="picture"> <br><br>
		<input id="title" name="title" type="text" placeholder="Your post's title"><br><br>
		<textarea name="text" rows="0" cols="1" id="text" placeholder="So, what happened today?&nbsp;(300 char max)"></textarea><br><br>
		<input  type="radio" name="privacy" value="public" checked><span class="privacy" >Public</span>
		<input  type="radio" name="privacy" value="private"><span class="privacy" >Private</span>
		<input class="submit" type="submit" name="submit">
	</form>
</div>
<!-- End Wrapper -->

<?php
			//If user HAS posted today
} else {

	?>
		<header>
	<h1> You Already Posted Today</h1>
</header>

	<?php


}

?>
</div>
</div>
<?php require_once('footer.php'); ?>