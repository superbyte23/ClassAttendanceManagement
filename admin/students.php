<?php
require 'include/header.php';
include 'include/config.php';

if (isset($_POST['add_student'])) {
		$stud_name = $_POST['stud_name'];
		$grade = $_POST['grade'];
		$section = $_POST['section'];
		$gender = $_POST['gender'];

		$query = "INSERT INTO `tbl_student`(`student_name`,`gender`, `student_grade`, `student_section`) VALUES ('$stud_name','$gender','$grade','$section')";

		$result = mysqli_query($conn, $query);

		if ($result) {
			header("location: students.php?success");
		}else{
			header("location: students.php?error");
		}
	}elseif (isset($_POST['search'])) {
		$stud_name = $_POST['stud_name'];
		$grade = $_POST['grade'];
		$section = $_POST['section'];
		$gender = $_POST['gender'];

		$load = "SELECT * FROM `tbl_student` s 
				LEFT JOIN tbl_grade g ON s.`student_grade` = g.id 
				LEFT JOIN tbl_section sec ON s.`student_section` = sec.id 
				WHERE `student_name` LIKE '%$stud_name%' AND `student_grade` = '$grade' AND `student_section` = '$section' AND `gender` LIKE '%$gender'
				order BY student_grade,student_section,gender, student_name";
	}else{
		$load = "SELECT * FROM `tbl_student` s 
				LEFT JOIN tbl_grade g ON s.`student_grade` = g.id 
				LEFT JOIN tbl_section sec ON s.`student_section` = sec.id 
				order BY student_grade,student_section,gender, student_name";
	}

	$total_students_sql = "SELECT count(*) as total FROM `tbl_student`";

	$total_students = mysqli_query($conn, $total_students_sql);
	if (mysqli_num_rows($total_students) > 0) {
		while ($row = mysqli_fetch_assoc($total_students)) {
			$total_count = $row['total'];
		}
	}
?>
  <body>
    <div class="page">
      	<div class="page-main">
        <?php require 'include/topbar.php'; ?> 
	        <div class="my-3 my-md-5">
	          	<div class="container">
	          		<div class="row">
	          			<div class="col-lg-12 order-lg-1 mb-4">
                			<form method="POST" action="" style="padding-bottom: 10px; padding-top: 5px; width: 100%;">
							    <div class="row">
							    	<div class="col-3">
										<input type="text" class="form-control stud_name" placeholder="Name" id="stud_name" name="stud_name" autocomplete="off" autofocus="">
							    	</div>
							    	<div class="col">
									      <select id="inputState" class="form-control" required="" name="gender">
									      	<option value="">Select Gender</option>
									        <option value="M">Male</option>
									        <option value="F">Female</option>
									        <option value="">ALL</option>
									      </select>
							    	</div>
							    	<div class="col">
									      <select id="inputState" class="form-control" required="" name="grade">
									        <?php 
												$ins = mysqli_query($conn, "SELECT * FROM `tbl_grade`");
									        	if (mysqli_num_rows($ins)>0) {
									        		while ($row_ins = mysqli_fetch_assoc($ins)) {
									        			echo '<option value="'.$row_ins['id'].'">'.$row_ins['grade'].'</option>';
									        		}
									        	}
									        ?>
									      </select>
							    	</div>
							    	<div class="col">
									      <select id="inputState" class="form-control" required="" name="section">
									        <?php 
									        	$ins = mysqli_query($conn, "SELECT * FROM `tbl_section`");
									        	if (mysqli_num_rows($ins)>0) {
									        		while ($row_ins = mysqli_fetch_assoc($ins)) {
									        			echo '<option value="'.$row_ins['id'].'">'.$row_ins['section_name'].'</option>';
									        		}
									        	}
									        ?>
									      </select>
							    	</div>
							    	<div class="col">
							    		<button type="submit" class="btn btn-primary btn-block" name="add_student" id="add_student"><i class="fe fe-plus-square"></i> Add</button>
							    	</div>
							    	<div class="col">
							    		<button type="submit" class="btn btn-info btn-block" name="search"><i class="fe fe-search"></i> Search</button>
							    	</div>
							      <!-- <li class="nav-item">
							        <a href="#" data-toggle="modal" data-target="#add_student" class="nav-link text-success"><i class="fe fe-plus"></i> Add Student</a>
							      </li>
							      <li class="nav-item">
							        <a href="#" data-toggle="modal" data-target="#search" class="nav-link text-info"><i class="fe fe-search"></i> Search</a>
							      </li> -->
							      <!-- <li class="nav-item">
							        <a href="./students.php" class="nav-link"><i class="fe fe-users"></i> Students</a>
							      </li>
							      <li class="nav-item">
							        <a href="./index.php" class="nav-link"><i class="fe fe-home"></i> Teacher</a>
							      </li> -->
							    </div>
							</form>
              			</div>
              			<div class="col-lg-12 order-lg-1 mb-4">
              				<caption>Total number of student(s) - <i class="text-red text-bold"><?php echo $total_count; ?></i></caption>
			            	<table class="table table-dark table-sm table-striped" id="example">
							  <thead>
							    <tr>
							      <th scope="col">#</th>
							      <th scope="col">Student Name</th>
							      <th scope="col">Grade</th>
							      <th scope="col">Section</th>
							      <th scope="col">Gender</th>
							      <th style="width: 15%;">Action</th>
							    </tr>
							  </thead>
							  <tbody id="result">
							  	<?php
							  	$student = mysqli_query($conn, $load);
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
							  	?>
							  </tbody>
							</table> 
              			</div>
	          		</div>
	        	</div>
	      	</div>
      	<?php require 'include/footer.php'; ?> 
    	</div>
	</div>
	<!-- Modal -->
	<!-- <div class="modal fade" id="add_student" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLongTitle">Add Student</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	        </button>
	      </div>

		     <form method="POST" action="">
		      <div class="modal-body">
				  <div class="form-group">
				    <label for="formGroupExampleInput">Student Name</label>
				    <input type="text" class="form-control" placeholder="Name" name="stud_name" required="" autocomplete="off">
				  </div>
				 <div class="form-group">
			      <label for="inputState">Grade</label>
			      <select id="inputState" class="form-control" required="" name="grade">
			        <?php 

			        		$ins = mysqli_query($conn, "SELECT * FROM `tbl_grade`");
			        		if (mysqli_num_rows($ins)>0) {
			        			while ($row_ins = mysqli_fetch_assoc($ins)) {
			        				echo '<option value="'.$row_ins['id'].'">'.$row_ins['grade'].'</option>';
			        			}
			        		}
			        	?>
			      </select>
			    </div>
					  <div class="form-group">
			      <label for="inputState">Section</label>
			      <select id="inputState" class="form-control" required="" name="section">
			        <?php 

			        		$ins = mysqli_query($conn, "SELECT * FROM `tbl_section`");
			        		if (mysqli_num_rows($ins)>0) {
			        			while ($row_ins = mysqli_fetch_assoc($ins)) {
			        				echo '<option value="'.$row_ins['id'].'">'.$row_ins['section_name'].'</option>';
			        			}
			        		}
			        	?>
			      </select>
			    </div>
			   
		      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        <button type="submit" class="btn btn-primary" name="add_student">Add</button>
	      </div>

			</form>
	    </div>
	  </div>
	</div> -->

	<script type="text/javascript" src="assets/js/vendors/jquery-3.2.1.min.js"></script>
	<script>
		$(document).ready(function() {
		    $('#example').DataTable();
		} );
		$(document).ready(function(){
			$('.stud_name').on('keyup', function(){
				var name = $(this).val();
				if (name) {
					$.ajax({
	                type:'POST',
	                url:'search_student2.php',
	                data:{name:name},
	                success:function(html){
	                	$('#result').html(html);
	                }
	            	});
				}
			});
		});
	</script>
  </body>
</html>