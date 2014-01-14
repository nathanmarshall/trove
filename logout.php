<?php
	session_start();	//	need this because we're accessing the session
	
	if (isset($_COOKIE[session_name()])) {	//	did the user's browser send a cookie for this session?
	    setcookie(session_name(), '', time()-42000, '/');	//	reset the cookie (empty it)
	}

	session_destroy();	//	destroy the session

	header('Location: login_form.php');	//	redirect browser to home page
?>