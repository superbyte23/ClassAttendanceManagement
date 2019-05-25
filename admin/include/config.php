<?php

$host = '127.0.0.1';
$user = 'root';
$pass = '';
$db_name = 'attendance_management_db';

try {
	$conn = mysqli_connect($host, $user, $pass, $db_name);
} catch (Exception $e) {
	echo 'Message: ' .$e->getMessage();
}

?>