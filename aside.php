<?php 
		require_once('includes/mysql.php');
	 	require_once('includes/db.php');

	 	//Get user Id 
		$userid = $_SESSION['logged_in_user'];

		$sql = "SELECT userId, userFname, userLname, userPic FROM users WHERE userId = $userid";

		$db = new MySQL($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['database']);
	
		$stm = $db->dbConn->prepare($sql);
	
		$stm->execute(array());
	
		$data = $stm->fetch(PDO::FETCH_ASSOC);
?>

<aside>	
	<!-- Menu -->
	<ul class="menu">
		<li><span class="icon-house"></span><a href="index.php">Feed</a></li>
		<?php echo '<li><span class="icon-book"></span><a href="journal.php?user='.$userid.'">My Trove</a></li>' ?>
		<li><span class="icon-compass"></span><a href="discover.php">Discover</a></li>
		<li><span class="icon-logout"></span><a href="logout.php">Logout</a></li>
		<li><a href="#"><img src="images/userimages/<?php echo $userid.'/'.$data['userPic'] ?>" height="40" width="40"><?php echo $data['userFname'].' '.substr($data['userLname'],0,1).'.' ?></a></li>
	</ul>
	<!-- End Menu -->
	<!-- New Post -->
	<a class="link-new" href="#">+ New Momento</a>
</aside>