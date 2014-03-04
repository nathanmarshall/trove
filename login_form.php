<!-- Include Head -->
<?php require_once('head.php'); ?>

	<!-- Wrapper Start -->
	<div class="wrapper login-form">
		<div class="form-container">
		<h1>TROVE</h1>
			<!-- Login Form -->
			<form action="login.php" method="post">
				<input type="text" name="handle" id="handle" placeholder="Username"> <br>
				<input type="password" name="password" id="pass" placeholder="Password"> <br>
				<input type="submit" value="Submit" class="btn-signinup">
			</form>
			<div class="return"><h3><a href="register.php">Register</a></h3></div>

		</div>
	</div>
	<!-- End Wrapper -->


<!-- Include Footer -->
<?php include_once('footer.php'); ?>