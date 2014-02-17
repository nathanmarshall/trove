<header class="mast-head">
  <div class="logo"><a href="#" class="hamburger"><span class="icon-list"></span></a></div>
<?php 
    //If user Profile is TRUE
    if (stripos($_SERVER['REQUEST_URI'], 'journal.php')) {
    //Establish User 
      $userid = $_GET['user'];

      $db = new MySQL($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['database']);

    //Get user Info 
      $sql = "SELECT userId, userFname, userLname, userHandle, userPic FROM users WHERE userId = ?";

      $stm = $db->dbConn->prepare($sql);

      $stm->execute(array($userid));

      $results = $stm->fetch();

      //echo '<img width="100px" style="border-radius: 50px" height="100px" src="images/userimages/'.$results['userId'].'/'.$results['userPic'].'">';
      echo '<h1>'.$results['userHandle'].'</h1>';
      echo '<h2>'.$results['userFname'].' '.$results['userLname'].'</h2>';
    
      //Follow user 
      if( $userid != $_SESSION['logged_in_user']){

        $logged_in_user = $_SESSION['logged_in_user'];


        //Checks for matching rows 
        $sql = "SELECT count(*) AS relationNumber FROM userRelationship WHERE relatedUserId = ? AND relatingUserId = ?";

        $stm = $db->dbConn->prepare($sql);

        $stm->execute(array($logged_in_user, $userid));

        $match_results = $stm->fetch();


        if ($match_results['relationNumber'] == 0){ 
          echo '<button class="btn-follow" data-follow="follow" data-user="'.$userid.'"><span class="icon-check"></span>Follow</button>';
        } else {
          echo '<button class="btn-follow following" data-follow="following" data-user="'.$userid.'"><span class="icon-check"></span>Follow</button>';
        }
      }
    } else {
      echo '<h1>TROVE</h1>';
    }
  ?>
</header>