<?php
include 'include/config.php';
if (isset($_GET['status'])) {
	if ($_GET['status'] == 'present') {
		
		$record = mysqli_query($conn, "INSERT INTO `tbl_attendance`(`member_id`, `class_id`, `att_date`, `att_status`) VALUES ('".$_GET['member_id']."','".$_GET['id']."',NOW(),'1')");
		if ($record) {
			header('location: class.php?id='.$_GET['id']);
		}else{
			header('location: class.php?id='.$_GET['id'].'&error');
		}


	}elseif ($_GET['status'] == 'absent') {
		$record = mysqli_query($conn, "INSERT INTO `tbl_attendance`(`member_id`, `class_id`, `att_date`, `att_status`) VALUES ('".$_GET['member_id']."','".$_GET['id']."',NOW(),'0')");
		if ($record) {
			header('location: class.php?id='.$_GET['id']);
		}else{
			header('location: class.php?id='.$_GET['id'].'&error');
		}
	}elseif ($_GET['status'] == 'late') {
		echo "Late";
	}
}
?>