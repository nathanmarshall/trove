<?php session_start();	?>
<?php require_once'head.php'; ?>

<div class="wrapper register">

	<div class="form-container">

		<h1> Join The Community </h1>

		<form method="post" action="<?php $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
				<input name="handle" id="handle" type="text" placeholder="Screen Name"> <br>
				<input name="fname" id="fname" type="text" placeholder="First Name"><br>
				<input name="lname" id="lname" type="text" placeholder="Last Name"><br>
				<input name="email" id="email" type="text" placeholder="Email"><br>
				<input name="password" id="password" type="password" placeholder="Password"><br>
				<input name="picture" id="picture" type="file" placeholder="Profile Picture" class="btn-signinup img-upload"><br>
			<input type="submit" name="submit" value="register" class="btn-signinup">
		</form>
		<div class="return"><h3><a href="login_form.php">Back</a></h3></div>

	</div>
</div>

	<?php 

	if(isset($_POST['submit'])){

		require_once 'includes/db.php';
		require_once 'includes/mysql.php';

		$db = new MySQL($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['database']);

		$sql = "SELECT userHandle FROM users WHERE userHandle = ?";

		$stm = $db->dbConn->prepare($sql);

		$stm -> execute(array(trim($_POST['handle'])));

		$results = $stm -> fetchAll();

		if($stm -> rowCount() === 1){

			echo 'username exists';
		} else {

			$salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));

			$password = hash('sha256', $_POST['password'].$salt);

			for ($i=0 ; $i < 65535 ; $i++ ) { 
				$password = hash('sha256', $_POST['password'].$salt);
			}

			$sql = "INSERT INTO users (userHandle, userFname, userLname, userEmail, userPass, salt, userSince) Values (?,?,?,?,?,?,NOW())";

			$stm = $db -> dbConn -> prepare($sql);

			$stm -> execute(array($_POST['handle'], 
								  $_POST['fname'],
								  $_POST['lname'], 
								  $_POST['email'],
								  $password,
								  $salt,
								  ));

			$new_id = $db->dbConn->lastInsertId();
			//PHP for IMAGE uploading 

			$upload_failure_warning ='';
			$allowed_extensions = array('jpg','jpeg','png', 'gif');

			//The File name 
			$uploaded_file = basename($_FILES['picture']['name']);

			//The File extension 
			$ext = substr($uploaded_file, strrpos($uploaded_file, '.') +1);

			//File Name without extension
			$uploaded_file = substr($uploaded_file, 0, strrpos($uploaded_file, '.'));

			if ($uploaded_file !== ''){

				if(in_array($ext, $allowed_extensions)){

					//THE upload path
					$target_path = $_SERVER['DOCUMENT_ROOT']. URL_ROOT . 'images/userimages/'.$new_id;

					//Create folder
					mkdir($target_path);

					//Replace underscores 
					$uploaded_file = str_replace(' ', '_', $uploaded_file);

					$uploaded_file .= time();
					
					//	pop the period and filename extension back on the end
					$uploaded_file .= '.' . $ext;

					if (move_uploaded_file($_FILES['picture']['tmp_name'], $target_path . '/' . $uploaded_file)) {
					
						//	the file move into the new directory worked! Let's update the new user's database record.
						//	 (store the filename in their img_url field)
						
						$sql = "UPDATE users SET userPic=? WHERE userId=?";
						
						$stm = $db->dbConn->prepare($sql);

      					$stm->execute(array($uploaded_file, $new_id));
      			
					} else {
						//	the file move didn't work! Place a message in the $upload_failure_warning variable.
						$upload_failure_warning = '. However, the image failed to upload. You may want to <a href="edit.php?id=' . $new_id . '">edit this user</a> and re-attempt the upload.';
					}

				}

			}
			header('Location: login_form.php');
		}

	}


	?>
