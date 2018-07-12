<?php

header('Content-Type: text/html; charset=utf-8');

if (isset($_POST['email'])) {
	$email = $_POST['email'];
	if (!empty($email)) {
		$con = new mysqli("localhost", "root", "namhoang", "budgetdb");
		if (mysqli_connect_errno()) {
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		} else {
			$search = mysqli_query($con, "SELECT * FROM users WHERE email = '$email'");
			if (!$search && mysqli_num_rows($search) == 0) {
				echo "empty";
			}else if(mysqli_num_rows($search) == 1){
				echo "Email has already existed !";
			}
		}
	}else{
		echo "empty";
	}
}
else{
	echo "empty";
}
?>