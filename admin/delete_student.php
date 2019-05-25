<?php require 'include/config.php';
if (isset($_GET['id'])) {
	$delete = mysqli_query($conn,"DELETE FROM `tbl_student` WHERE `student_id` =".$_GET['id']);
	if ($delete) {
		header('location: students.php');
	}else{
		header('location: students.php?error');
	}
}
?>