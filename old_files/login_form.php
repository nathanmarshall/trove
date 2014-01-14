<!-- Include Head -->
<?php require_once('head.php'); ?>

	<!-- Wrapper Start -->
	<div class="wrapper">
	
		<!-- Login Form -->
		<form action="login.php" method="post">
			<label for="handle">Username:</label>
			<input type="text" name="handle" id="handle"> <br>
			<label for="password">Password:</label>
			<input type="password" name="password" id="pass"> <br>
			<input type="submit" value="Submit">
		</form>
		
	
	</div>
	<!-- End Wrapper -->


<!-- Include Footer -->
<?php include_once('footer.php'); ?>