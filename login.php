<?php 
//Login PHP

$post = $_POST["handle"];

if (!isset($_POST['handle'])) {
		header('Location: login_form.php?error='.$post.''); exit;
	} else {
		if ($_POST['handle'] === '' && $_POST['password'] === '') {
			header('Location: ' . $_POST['from_page'] . '?error=userandpass');
			exit;
		} else if ($_POST['password'] === '') {
			header('Location: ' . $_POST['from_page'] . '?error=pass');
			exit;
		} else if ($_POST['handle'] === '') {
			header('Location: ' . $_POST['from_page'] . '?error=user');
			exit;
		}
	}



require_once('includes/mysql.php');
require_once('includes/db.php');


$db = new MySQL($dbconfig['host'], $dbconfig['user'], $dbconfig['password'],$dbconfig['database']);

//Assumes user is false 
$valid_user = false;

//The login query
$sql = "SELECT userId, userHandle, userPass, salt, userFname, userLname FROM users WHERE userHandle =?";


$stm = $db->dbConn->prepare($sql);

	$stm->execute(array(trim($_POST['handle'])));

	$result = $stm->fetchAll();
	
	if ($stm->rowCount() === 1) {

		foreach ($result as $row) {
			
			$check_password = hash('sha256', $_POST['password'] . $row['salt']); 
			for($round = 0; $round < 65535; $round++) { 
		     $check_password = hash('sha256', $_POST['password']. $row['salt']); 
			}

		
			if($check_password === $row['userPass']) {	// If the hashed password the user submitted
														// matches the one from the users table:

			    $valid_user = true; 
					session_start();	//	start the session and create a session variable

					$_SESSION['logged_in_user'] = $row['userId'];
					
					header('Location: index.php'); // redirect user to the homepage
					exit();
			}
		}
	}

if (!$valid_user) {	//	no valid user was found?
		header('Location: login_form.php?error=invalid');	//	####	RETURN TO HOMEPAGE WITH ERROR in query string

	}

?>