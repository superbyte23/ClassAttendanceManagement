<?php require 'include/header.php';
include 'include/config.php';
if (isset($_POST['addclass'])) {
		$student_id = $_POST['student_id'];

		$check_student = mysqli_query($conn,"SELECT * FROM `tbl_class_member` WHERE `class_id` = ".$_GET['id']." AND `student_id` = '$student_id' ");
		if (mysqli_num_rows($check_student)>0) {
			header("location: class.php?id=".$_GET['id']."&error");
		}elseif(is_null($student_id) or $student_id == 0){
			header("location: class.php?id=".$_GET['id']."&error");
		}else{
			$query = "INSERT INTO `tbl_class_member`(`class_id`, `student_id`) VALUES ('".$_GET['id']."','$student_id')";
			$result = mysqli_query($conn, $query);
			if ($result) {
				header("location: class.php?id=".$_GET['id']."&success");
			}else{
				header("location: class.php?id=".$_GET['id']."&error");
			}
		}

		
	}
$class = mysqli_query($conn, "SELECT * FROM `tbl_class` WHERE `class_id` =".$_GET['id']);
$res = mysqli_num_rows($class);
while ($row = mysqli_fetch_assoc($class)) {
	$class_name = $row['class_name'];
	$class_schedule = $row['class_schedule'];	
	$class_desc = $row['class_desc'];
	
}
?> 
  <body class="bg-dark">
    <div class="page">
      	<div class="page-main">
        <?php require 'include/topbar.php'; ?> 
	        <div class="my-3 my-md-5">
	          	<div class="container">
	            	<?php include 'class_menu.php'; ?>
	            	<div class="row">
	            		<div class="col-12">
	            			<input type="text" name="search" class="form-control" placeholder="Search Name" id="search">
	            			<table class="table table-striped table-sm table-dark" id="grade_table">
							  <thead>
							    <tr>
							    	<th>Id</th>
							      	<th>Student Name</th>
							      	<th>Action</th>
							      	<th>1st</th>
							      	<th>2nd</th>
							      	<th>3rd</th>
							      	<th>4th</th>
							      	<th>Final</th>
							    </tr>
							  </thead>
							  <tbody>
							    <?php include 'grade_table.php';
							    load($_GET['id'], $conn);
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
	<div id="test"></div>
<div class="modal fade" id="add_student" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
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
			    <label for="formGroupExampleInput">Search Student</label>
			    <input type="text" class="form-control stud_name" placeholder="Name" name="student_name" id="student_name" required="" autocomplete="off" value="" autofocus="">
			    <input type="text" name="student_id" id="student_id" hidden="" value="">
			    <div id="result">
			    	
			    </div>
			  </div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        <button type="submit" class="btn btn-primary" name="addclass">Add</button>
	      </div>

		</form>
    </div>
  </div>
</div>
<div class="modal fade" id="edit_grade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="studentname"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        </button>
      </div>
	     <form method="POST" action="#">
	      <div class="modal-body">
	      	<div class="form-group">
		      	<!-- <label class="form-label">First Grading</label> -->
		      	<input type="number" name="1st" id="1st" class="form-control" placeholder="First Grading" maxlength="100">
	      	</div>
	      	<div class="form-group">
		      	<!-- <label class="form-label">Second Grading</label> -->
		      	<input type="number" name="2nd" id="2nd" class="form-control" placeholder="Second Grading" maxlength="100">
	      	</div>
	      	<div class="form-group">
		      	<!-- <label class="form-label">Third Grading</label> -->
		      	<input type="number" name="3rd" id="3rd" class="form-control" placeholder="Third Grading" maxlength="100">
	      	</div>
	      	<div class="form-group">
		      	<!-- <label class="form-label">Fourth Grading</label> -->
		      	<input type="number" name="4th" id="4th" class="form-control" placeholder="Fourth Grading" maxlength="100">
	      	</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
	        <button type="button" class="btn btn-primary" name="update" id="update">Update</button>
	      </div>

		</form>
    </div>
  </div>
</div> 
<script type="text/javascript" src="assets/js/vendors/jquery-3.2.1.min.js"></script>
	<script>
		$(document).ready(function(){
			$('.stud_name').on('keyup', function(){
				var name = $(this).val();
				if (name) {
					$.ajax({
	                type:'POST',
	                url:'search_student.php',
	                data:{name:name},
	                success:function(html){
	                	$('#result').html(html);
	                }
	            	});
				}
			});
			$('#date').on('change', function(){
				var date = $(this).val();
				var class_id = <?php echo $_GET['id']; ?>;
				if (date) {
					$.ajax({
	                type:'POST',
	                url:'backend_search_date_attendance.php',
	                data:{date:date, class_id:class_id},
	                success:function(html){
	                	$('#search_date').html(html);
	                }
	            	});
				}
			});
			$('#add_student').on('shown.bs.modal', function () {
						$('#student_name').focus();
			});			

			$(function() {
			    // use event delegation
			    $(document).on('click','#grade_table tr', function() {
			    	// student id
			        var student_id = $(this).find('td:eq(0)').text();
			        // student name
			        var student_name = $(this).find('td:eq(1)').text();
			       	// first_grade
			       	var first_grade = $(this).find('td:eq(3)').text();
			       		// second_grade
			       	var second_grade = $(this).find('td:eq(4)').text();
			       		// third_grade
			       	var third_grade = $(this).find('td:eq(5)').text();
			       		// fourth_grade
			       	var fourth_grade = $(this).find('td:eq(6)').text();
    				
    				$('#1st').val(first_grade);
    				$('#2nd').val(second_grade);
    				$('#3rd').val(third_grade);
    				$('#4th').val(fourth_grade); 
    				$('#studentname').text('Name : ' + student_name);
			    });
			});

			$('.editgrade').on('click', function () {				
					var studid = $(this).data('index');
				$('#update').on('click', function() {
					var classid = <?php echo $_GET['id']; ?>;
					var first = $('#1st').val();
					var second = $('#2nd').val();
					var third = $('#3rd').val();
					var fourth = $('#4th').val(); 
					// alert(studid);
					// alert(classid);
					// alert(first);
					// alert(second);
					// alert(third);
					// alert(fourth);
					$.ajax({
	                type:'POST',
	                url:'update_insert_grade.php',
	                data:{studid:studid, classid:classid, first:first, second:second, third:third, fourth:fourth},
	                success:function(html){
	                	// $('#test').html(html);               	
	                	location.reload(true);
	                }
	            	});
				});
			});

			$(function(){
				$('#search').keyup(function() {
				  	var value = $(this).val().toLowerCase();
				    $("#grade_table tr").filter(function() {
				      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
				    });
				});
			});
		});
	</script>
	<style type="text/css">
		input[type='date']#date{
			height: inherit;
			max-height: inherit;
			width: 30%;
			float:right; 
			display: inline-block;
            margin-right: -20px;
		}
		button#shadow{
			height: inherit;
			max-height: inherit;
			float:right; 
			display: inline-block;
            margin-right: 10px;
		}
	</style>
	
  </body>
</html>