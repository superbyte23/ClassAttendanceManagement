<div class="dropdown" id="listed" style="display:inline-block;">
	<?php
	include 'include/config.php';
	if (isset($_POST['name'])) {
		$name = $_POST['name'];
		$student = mysqli_query($conn, "SELECT * FROM `tbl_student` s LEFT JOIN tbl_grade g ON s.`student_grade` = g.id LEFT JOIN tbl_section sec ON s.`student_section` = sec.id WHERE `student_name` LIKE '%".$name."%'");
		if (mysqli_num_rows($student)>0) {

			while ($row = mysqli_fetch_assoc($student)) {
				echo '<a class="dropdown-item student" href="#" data-index="'.$row["student_id"].'" data-value="'.$row['student_name'].'">
                      <i class="dropdown-icon fe fe-user"></i> '.$row['student_name'].', '.$row["grade"].' - '.$row["section_name"].'
                    </a>';
			}
		}else{
			echo "No Result Found";
		}
	}else{
		echo "No Result Found";
	}
?>
<script type="text/javascript">
	$(function(){
		$('a.student').on('click', function(){
			var id = $(this).data('index');
			var student_name = $(this).data('value');
			$('#student_id').val(id);
			$('#student_name').val(student_name);
			$('#listed').remove();
		})
	})
</script>
</div>