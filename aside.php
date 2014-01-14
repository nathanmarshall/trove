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

	<!-- User Info -->
	<div class="user-info">
		
		<img src="images/userimages/<?php echo $userid.'/'.$data['userPic'] ?>" height="40" width="40">
		<!-- User Name -->
		<h2><?php echo $data['userFname'].' '.substr($data['userLname'],0,1).'.' ?></h2>
	</div>
	<!-- End user info -->

	<!-- Menu -->
	<ul class="menu">
		<li><a href="index.php">Feed</a></li>
		<?php echo '<li><a href="journal.php?user='.$userid.'">My Journal</a></li>' ?>
		<li><a href="discover.php">Discover</a></li>
		<li><a href="logout.php">Logout</a></li>

	</ul>
	<!-- End Menu -->
</aside>