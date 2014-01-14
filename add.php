<?php session_start() ?>
<!-- PHP for adding event-->
<?php


 require_once('includes/mysql.php');
	require_once('includes/db.php');

	//Text
	$title = $_POST['title'];
	$text = $_POST['text'];
	$userid = $_SESSION['logged_in_user'];
	$privacy = $_POST['privacy'];
	

//PHP for IMAGE uploading 
			$db = new MySQL($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['database']);
			


			$new_id = $_SESSION['logged_in_user'];
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
					$target_path = $_SERVER['DOCUMENT_ROOT']. URL_ROOT . 'images/postimages/'.$new_id;

					//Create folder
					if (!file_exists($target_path)) {
    					mkdir($target_path);
    				}

					//Replace underscores 
					$uploaded_file = str_replace(' ', '_', $uploaded_file);

					$uploaded_file .= time();
					
					//	pop the period and filename extension back on the end
					$uploaded_file .= '.' . $ext;

					if (move_uploaded_file($_FILES['picture']['tmp_name'], $target_path . '/' . $uploaded_file)) {
					
						//	the file move into the new directory worked! Let's update the new user's database record.
						//	 (store the filename in their img_url field)
      			
					} else {
						//	the file move didn't work! Place a message in the $upload_failure_warning variable.
						//$upload_failure_warning = '. However, the image failed to upload. You may want to <a href="edit.php?id=' . $new_id . '">edit this user</a> and re-attempt the upload.';
					}
				}	

				
						$sql = "INSERT INTO posts (userId, postTitle, postText, postPrivacy, postDate, postPhoto) VALUES (?,?,?,?,?,?)";
						
						$stm = $db->dbConn->prepare($sql);

						$now = date('Y-m-d H:i:s');

      					$stm->execute(array($userid, $title, $text, $privacy, $now , $uploaded_file));

 header('Location: index.php');      			
}
?>