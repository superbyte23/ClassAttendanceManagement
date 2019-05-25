	<?php
	include 'include/config.php';
	if (isset($_POST['name'])) {
		$name = mysqli_escape_string($conn,$_POST['name']);
		$student = mysqli_query($conn, "SELECT * FROM `tbl_student` s 
				LEFT JOIN tbl_grade g ON s.`student_grade` = g.id 
				LEFT JOIN tbl_section sec ON s.`student_section` = sec.id 
				WHERE s.`student_name` LIKE '%".$name."%'
				order BY student_grade,student_section,gender, student_name");
		if (mysqli_num_rows($student)>0) {
					    		while ($row = mysqli_fetch_assoc($student)) {
					    		echo "<tr>";
					    		echo "<td>".$row['student_id']."</td>";
					    		echo "<td>".$row['student_name']."</td>";
					    		echo "<td>".$row['grade']."</td>";
					    		echo "<td>".$row['section_name']."</td>";
					    		echo "<td>".$row['gender']."</td>";
					    		echo "<td><a href='edit_student.php?id=".$row['student_id']."' class='btn btn-sm btn-info'>Edit</a>  <a href='delete_student.php?id=".$row['student_id']."' class='btn btn-sm btn-danger'> Delete</a></td>";
					    		echo "</tr>";
					    		}
					    	}else{
					    		echo "<tr>";
					    		echo "<td colspan='6' class='text-center'>No Data Found</td>";
					    		echo "</tr>";
					    	}
	}else{
		echo "No Result Found";
	}
?>