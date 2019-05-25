<?php require 'include/header.php';
include 'include/config.php';
if (isset($_POST['addclass'])) {
		$student_id = $_POST['student_id'];

		$query = "INSERT INTO `tbl_class_member`(`class_id`, `student_id`) VALUES ('".$_GET['id']."','$student_id')";
		$result = mysqli_query($conn, $query);
		if ($result) {
			header("location: class.php?id=".$_GET['id']."&success");
		}else{
			header("location: class.php?id=".$_GET['id']."&error");
		}
	}
?> 
  <body class="">
    <div class="page">
      	<div class="page-main">
        <?php require 'include/topbar.php'; ?> 
	        <div class="my-3 my-md-5">
	          	<div class="container">
	            	<div class="page-header">
		              	<h1 class="page-title">
		                	View Attendance
		                	<a href="class.php?id=<?php echo $_GET['id'] ?>" class="btn btn-info">Check Attendance</a> 
		                	<!-- <div class="align-right">
		                		<button data-toggle="modal" data-target="#add_student" class="btn btn-sm btn-success">Add Student</button>    
		                	</div> -->
		              	</h1>
	            	</div>
	            	<h3>Date : <?php echo date('Y-m-d'); ?> </h3>
	            	<table class="table table-dark">
					  <thead>
					    <tr>
					      <th scope="col">#</th>
					      <th scope="col">Student</th>
					      <th scope="col" style="width: 20%;">Status</th>
					    </tr>
					  </thead>
					  <tbody>
					    <?php
					    	
					    	$query = mysqli_query($conn, "SELECT * FROM `tbl_class_member` cm left join tbl_student s on cm.student_id = s.student_id LEFT JOIN tbl_attendance a ON cm.`member_id` = a.member_id WHERE cm.`class_id` = '".$_GET['id']."' AND att_date LIKE '%".date('Y-m-d')."%'");
					    	if (mysqli_num_rows($query) > 0) {
					    		while ($row = mysqli_fetch_assoc($query)) { 
					    		echo "<tr>";
					    		echo "<td>".$row['member_id']."</td>";
					    		echo "<td>".$row['student_name']."</td>";
					    		echo "<td>".$row['att_status']."</td>";
					    		echo "</tr>";
					    		}
					    	}else{
					    		echo "<tr>";
					    		echo "<td>No Data Found</td>";
					    		echo "</tr>";
					    	}
					    ?>
					  </tbody>
					</table>
	        	</div>
	      	</div>
      	<?php require 'include/footer.php'; ?> 
    	</div>
	</div>
	<!-- Modal -->
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
			    <input type="text" class="form-control stud_name" placeholder="Name" name="student_name" id="student_name" required="" autocomplete="off" value="">
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
		});
	</script>
  </body>
</html>