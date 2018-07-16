<?php

header('Content-Type: text/html; charset=utf-8');

if (isset($_POST['bill_id'])) {
	$bill_id = $_POST['bill_id'];
	if (!empty($bill_id)) {
		$con = new mysqli("localhost", "root", "namhoang", "budgetdb");
		if (mysqli_connect_errno()) {
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		} else {
			$search = mysqli_query($con, "SELECT * FROM tblbills WHERE id = '$bill_id'");
			if (!$search && mysqli_num_rows($search) == 0) {
				echo "empty";
			}else if(mysqli_num_rows($search) == 1){
				echo "Bill ID has already existed !";
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