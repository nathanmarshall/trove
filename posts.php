<?php 

echo '<img width="30px" height="30px" src="images/userimages/'.$data['userId'].'/'.$data['userPic'].'">';
echo '<h3>'.$data['userFname'].' '.$data['userLname'].'<h3>';
if($data['postPhoto'] != ''){
	echo '<img width="300px" height="300px" src="images/postimages/'.$data['userId'].'/'.$data['postPhoto'].'">';
}
echo '<h2>'.$data['postTitle'].'<h2>';
echo '<h3>'.$data['postText'].'<h3>';


//Gems 

$logged_in_user = $_SESSION['logged_in_user'];
$gemPostId = $data['postId'];
$gemUserId = $_SESSION['logged_in_user'];

$sql = "SELECT count(gemId) AS gems FROM gems WHERE gemPostId = ? AND gemUserId = ?";

$stm = $db->dbConn->prepare($sql);

$stm->execute(array($gemPostId, $gemUserId));

$match_results = $stm->fetch();

if ($match_results['gems'] == 0){	
	echo '<form action="social.php?gem=yes&post='.$data['postId'].'" method="post"><button value="gem" name="gem">Gem</button></form>'.$results['gemNumber'];
} else {
	echo '<form action="social.php?gem=delete&post='.$data['postId'].'" method="post"><button value="gem" name="gem">Un Gem</button></form>'.$results['gemNumber'];
}


echo '<form action="social.php?action=comment" method="post">
<label for="comment">Comment:</label>
<input type="hidden" name="post" value="'.$data['postId'].'">
<input type="text" name="comment" id="comment">
<input type="submit" name="comment_submit" value="post">
</form>
<br>';

echo 'Comments';
echo '<hr>';
foreach ($cresults as $data) {

	echo $data['userHandle'].':  '.$data['comment'];
	echo '<br>';
}

echo "<br><br><br>";


}

?>