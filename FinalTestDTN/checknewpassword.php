<?php

header('Content-Type: text/html; charset=utf-8');

if (isset($_POST['password'])) {
	$password = $_POST['password'];
	if (!empty($password)) {
		if (strlen($password) <8) {
			echo "Password must at least 8 character !";
		}
	}else{
		echo "empty";
	}
}
else{
	echo "empty";
}
?>