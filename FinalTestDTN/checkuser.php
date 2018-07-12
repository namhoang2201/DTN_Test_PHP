<?php

header('Content-Type: text/html; charset=utf-8');

if (isset($_POST['username'])) {
	$username = $_POST['username'];
	if (!empty($username)) {
		$con = new mysqli("localhost", "root", "namhoang", "budgetdb");
		if (mysqli_connect_errno()) {
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		} else {
			$search = mysqli_query($con, "SELECT * FROM users WHERE user_name = '$username'");
			if (!$search || mysqli_num_rows($search) == 0) {
				echo "Username incorrect !";
			} 
		}
	}
}
else{
	echo "empty";
}
?>