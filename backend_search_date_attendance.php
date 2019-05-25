<?php
include 'include/config.php';
if (!empty($_POST['date'])){
	$date = $_POST['date'];
	$class_id = $_POST['class_id'];
	$query = mysqli_query($conn, "SELECT * FROM `tbl_class_member` cm left join tbl_student s on cm.student_id = s.student_id LEFT JOIN tbl_attendance a ON cm.`member_id` = a.member_id WHERE cm.`class_id` = '".$class_id."' AND att_date LIKE '%".$date."%' order BY student_grade,student_section,gender, student_name");
	if (mysqli_num_rows($query) > 0) {
		while ($row = mysqli_fetch_assoc($query)) { 
		echo "<tr>";
		echo "<td>".$row['member_id']."</td>";
		echo "<td>".$row['student_name']."</td>";
		if ($row['att_status'] == '0') {
			echo "<td class='text-danger'>Absent</td>";
		}elseif ($row['att_status'] == '1') {
			echo "<td class='text-success'>Present</td>";
		}else{
			echo "<td class='text-info'>Late</td>";
		}
		echo "</tr>";
		}
	}else{
		echo "<tr>";
		echo "<td colspan='3' class='text-center'>No Data Found</td>";
		echo "</tr>";
	}				    		
}					    	
					    	
?>