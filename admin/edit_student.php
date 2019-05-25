<?php require 'include/header.php';
$st = mysqli_query($conn, "SELECT * FROM tbl_student WHERE student_id =".$_GET['id']);
if (mysqli_num_rows($st)>0) {
	while ($rows = mysqli_fetch_assoc($st)) {
		$name = $rows['student_name'];
		$student_grade = $rows['student_grade'];
		$student_section = $rows['student_section'];
		$gender = $rows['gender'];
	}
}
include 'include/config.php';
if (isset($_POST['update_student'])) {
		$stud_name = $_POST['stud_name'];
		$grade = $_POST['grade'];
		$section = $_POST['section'];
		$gender1 = $_POST['gender'];

		$query = "UPDATE `tbl_student` SET `student_name`='$stud_name',`gender`='$gender1',`student_grade`='$grade',`student_section`='$section' WHERE `student_id` =".$_GET['id'];

		$result = mysqli_query($conn, $query);

		if ($result) {
			header("location: students.php?success");
		}else{
			header("location: students.php?error");
		}
	}
?> 
  <body class="">
    <div class="page">
      	<div class="page-main">
        <?php require 'include/topbar.php'; ?> 
	        <div class="my-3 my-md-5">
	          	<div class="container">
					<form method="POST" action="" class="row">
						<div class="form-group col-6">
						    <label for="formGroupExampleInput">Student Name</label>
						    <input type="text" class="form-control" placeholder="Name" name="stud_name" required="" autocomplete="off" value="<?php echo $name; ?>">
						 </div>
						 <div class="form-group col-6">
					      <label for="inputState">Grade</label>
					      <select id="inputState" class="form-control" required="" name="grade">
					        <?php 

					        		$ins = mysqli_query($conn, "SELECT * FROM `tbl_grade` ");
					        		if (mysqli_num_rows($ins)>0) {
					        			while ($row_ins = mysqli_fetch_assoc($ins)) {
					        				if ($row_ins['id'] == $student_grade) {
					        					echo '<option value="'.$row_ins['id'].'" selected>'.$row_ins['grade'].'</option>';
					        				}else{
					        					echo '<option value="'.$row_ins['id'].'">'.$row_ins['grade'].'</option>';
					        				}
					        			}
					        		}
					        	?>
					      </select>
					    </div>
							  <div class="form-group col-6">
					      <label for="inputState">Section</label>
					      <select id="inputState" class="form-control" required="" name="section">
					        <?php 

					        		$ins = mysqli_query($conn, "SELECT * FROM `tbl_section`");
					        		if (mysqli_num_rows($ins)>0) {
					        			while ($row_ins = mysqli_fetch_assoc($ins)) {
					        				if ($row_ins['id'] == $student_section) {
					        					echo '<option value="'.$row_ins['id'].'" selected>'.$row_ins['section_name'].'</option>';
					        				}else{
					        					echo '<option value="'.$row_ins['id'].'">'.$row_ins['section_name'].'</option>';
					        				}
					        			}
					        		}
					        	?>
					      </select>
					    </div>
					    <div class="form-group col-6">
					      <label for="inputState">Section</label>
					      <select id="inputState" class="form-control" required="" name="gender">
					       <?php 
					       if ($gender == 'M') {
					      		echo ' <option value="M" selected>Male</option>';
					      		echo ' <option value="F">Female</option>';
					       }elseif ($gender == 'F') {
					       		echo ' <option value="F" selected>Female</option>';
					       		echo ' <option value="M">Male</option>';
					       }else{
						       	echo ' <option value="M">Male</option>';
						       	echo ' <option value="F">Female</option>';
					       }

					       ?>
					      </select>
					    </div>
					    <div class="form-group col-12">
					        <button type="button" onclick="history.back();" class="btn btn-secondary" data-dismiss="modal">Back</button>
					        <button type="submit" class="btn btn-primary" name="update_student">Update</button>
					    </div>
					</form>
	        	</div>
	      	</div>
      	<?php require 'include/footer.php'; ?> 
    	</div>
	</div>
  </body>
</html>