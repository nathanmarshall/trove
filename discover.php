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

			

		<!-- Search form -->

		<form class="discover-search" action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
			<input type="text" name="search" id="search" placeholder="Search by username">
		</form>


		<!-- Search Results -->
		<?php

		require_once 'includes/db.php';
		require_once 'includes/mysql.php';

			//If user searches
			if(isset($_POST['search'])){

				$search = $_POST['search'];

				$sql = "SELECT userFname, userLname, userId, userHandle, userPic FROM users WHERE userHandle LIKE '$search%' ";

				$db = new MySQL($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['database']);

				$stm = $db->dbConn->prepare($sql);
	
			    $stm->execute(array());

			    $results = $stm->fetchAll();

			// print_r($results);

			    foreach($results as $data){

					echo '<div class="discover-user">';
					echo '<a href="journal.php?user='.$data['userId'].'"><img width="30" height="30" src="images/userimages/'.$data['userId'].'/'.$data['userPic'].'"></a>';
					echo '<div class="discover-info">';
					echo '<a href="journal.php?user='.$data['userId'].'"><h2>'.$data['userHandle'].'</h2></a>';
					echo '<a href="journal.php?user='.$data['userId'].'"><h3>'.ucfirst($data['userFname']).' '.ucfirst(substr($data['userLname'],0,1)).'.</h3></a>';
					echo '</div>';
					echo '</div>';

				}

			//Displays Friends by default 
			} else {

			
				$currentUser = $_SESSION['logged_in_user'];

				$sql = "SELECT relatedUserId, relatingUserId, relation, users.userFname, users.userLname, users.userPic, users.userId, users.userHandle FROM userRelationship INNER JOIN users ON userRelationship.relatingUserId = users.userId
				WHERE relatedUserId = $currentUser" ;

				$db = new MySQL($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['database']);

				$stm = $db->dbConn->prepare($sql);
	
			    $stm->execute(array());

			    $results = $stm->fetchAll();

			// print_r($results);

			    foreach($results as $data){
					echo '<div class="discover-user">';
					echo '<a href="journal.php?user='.$data['userId'].'"><img width="30" height="30" src="images/userimages/'.$data['userId'].'/'.$data['userPic'].'"></a>';
					echo '<div class="discover-info">';
					echo '<a href="journal.php?user='.$data['userId'].'"><h2>'.$data['userHandle'].'</h2></a>';
					echo '<a href="journal.php?user='.$data['userId'].'"><h3>'.ucfirst($data['userFname']).' '.ucfirst(substr($data['userLname'],0,1)).'.</h3></a>';
					echo '</div>';
					echo '</div>';

				}

			}

			

		?>

		</div>
		<!-- End Content Wrapper -->


	</div>
	<!-- End Wrapper -->


<!-- Include Footer -->
<?php 
}
include_once('footer.php'); ?>



<!-- Start Event 
			<article class="event">
				
			<img src="images/event.jpg" >
			<p> Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec.</p>
			
			
			</article>
			 End Event -->