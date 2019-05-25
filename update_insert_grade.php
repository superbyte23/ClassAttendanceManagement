<?php
include 'include/config.php';
if (!empty($_POST['studid'])){

	$studid = $_POST['studid'];
	$classid = $_POST['classid'];
	$first = $_POST['first'];
	$second = $_POST['second'];
	$third = $_POST['third'];
	$fourth = $_POST['fourth'];
	
	// check student grade table if student has already the first grade

	$query = mysqli_query($conn, "SELECT * FROM `student_grades_hs` WHERE `student_id` = $studid AND `class_id` = $classid");
	
	if (mysqli_num_rows($query) > 0){
		// update student grade
		echo "Success";
		$sql_update = mysqli_query($conn, "UPDATE `student_grades_hs` SET 
			`1st_grading`= '$first',
			`2nd_grading`= '$second',
			`3rd_grading`= '$third',
			`4th_grading`= '$fourth'
			WHERE `student_id` = '$studid' AND `class_id` = $classid");

	}else{
		try {
			$sql_insert = mysqli_query($conn, "INSERT INTO `student_grades_hs`(`student_id`, `class_id`, `1st_grading`, `2nd_grading`, `3rd_grading`, `4th_grading`) VALUES ('$studid', '$classid', '$first', '$second', '$third', '$fourth')");
		} catch (Exception $e) {
			echo 'Message: ' .$e->getMessage();
		}
	}				    		
}					    	
					    	
?>
