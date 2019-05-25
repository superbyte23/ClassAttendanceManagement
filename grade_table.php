
<?php

function load($id, $conn){

	$grd = mysqli_query($conn, "
		SELECT STD.`student_id` as 'sid', STD.`student_name` as 'sname', 
		(CASE WHEN grd.`1st_grading` IS NULL THEN 0 ELSE grd.`1st_grading` END) AS '1st_grading', 
		(CASE WHEN grd.`2nd_grading` IS NULL THEN 0 ELSE grd.`2nd_grading` END) AS '2nd_grading', 
		(CASE WHEN grd.`3rd_grading` IS NULL THEN 0 ELSE grd.`3rd_grading` END) AS '3rd_grading', 
		(CASE WHEN grd.`4th_grading` IS NULL THEN 0 ELSE grd.`4th_grading` END) AS '4th_grading', 
		(`1st_grading`+`2nd_grading`+`3rd_grading`+`3rd_grading`) AS 'final' 
		FROM `tbl_student` STD 
		LEFT JOIN tbl_class_member clm ON STD.`student_id` = clm.student_id 
		LEFT JOIN student_grades_hs grd ON STD.`student_id` = grd.student_id 
		WHERE clm.`class_id` = $id ORDER BY gender, sname");

    	if (mysqli_num_rows($grd) > 0) {
    		while ($row = mysqli_fetch_assoc($grd)) {
    			echo "<tr>";
					echo "<td>".$row['sid']."</td>";
					echo "<td>".$row['sname']."</td>";
					echo "<td><a data-toggle='modal' data-target='#edit_grade' class='editgrade text-white btn btn-info btn-sm' data-index='".$row['sid']."'><i class='fe fe-edit'></i> Edit Grade</a>";
					echo "<td class='editMe'>".$row['1st_grading']."</td>";
					echo "<td class='editMe'>".$row['2nd_grading']."</td>";
					echo "<td class='editMe'>".$row['3rd_grading']."</td>";
					echo "<td class='editMe'>".$row['4th_grading']."</td>";

					echo "<td>".$row['final'] / 4 ."</td>";
				echo "</tr>";
    		}
    		// $member_id = implode(',', $id);
    	}else{
    		// $member_id = '0';
    	}
}

					    	
?>