<?php require 'include/header.php';
include 'include/config.php';
$class = mysqli_query($conn, "SELECT * FROM `tbl_class` WHERE `class_id` =".$_GET['id']);
$res = mysqli_num_rows($class);
while ($row = mysqli_fetch_assoc($class)) {
	$class_name = $row['class_name'];
	$class_schedule = $row['class_schedule'];	
	$class_desc = $row['class_desc'];
	
}
?> 
  <body class="">
    <div class="page">
      	<div class="page-main">
        <?php require 'include/topbar.php'; ?> 
	        <div class="my-3 my-md-5">
	          	<div class="container">
	            	<div class="h2" style="margin-top: -15px">Class Name : <?php echo $class_name; ?> | <?php echo $class_schedule; ?> | <?php echo $class_desc; ?></div>
	            	<button data-toggle="modal" id="shadow" data-target="#add_student" class="btn btn-info" style="margin-top: -15px; margin-bottom: 10px;"> Back</button>
	            	<a href="class_record.php?id=<?php echo $_GET['id']; ?>" id="shadow" class="btn btn-success" style="margin-top: -15px; margin-bottom: 10px;">Class Record</a>
	            	<div class="row">
	            		<div class="col-6">
	            			<table class="table table-dark  table-striped table-sm">
					  <thead>
					    <tr>
					      <th>Student</th>
					      <th>Gender</th>
					      <th>Action</th>
					    </tr>
					  </thead>
					  <tbody>
					    <?php
					    	$att = mysqli_query($conn, "SELECT * FROM `tbl_attendance` WHERE att_date like '%".date('Y-m-d')."%' AND class_id = ".$_GET['id']);
					    	$att_result = mysqli_num_rows($att);
					    	if ($att_result > 0) {
					    		while ($row_att = mysqli_fetch_assoc($att)) {
					    			$id[] = $row_att['member_id'];
					    		}
					    		$member_id = implode(',', $id);
					    	}else{
					    		$member_id = '0';
					    	}

					    	$query = mysqli_query($conn, "SELECT * FROM `tbl_class_member` cm LEFT JOIN tbl_student s on cm.`student_id` = s.`student_id` WHERE cm.`member_id` NOT IN ($member_id) AND class_id =".$_GET['id']." order BY student_grade,student_section,gender, student_name");
					    	$result = mysqli_num_rows($query);

					    	if ($result > 0) {
					    		while ($row = mysqli_fetch_assoc($query)) {
					    			echo "<tr>";
										echo "<td>".$row['student_name']."</td>";
										echo "<td>".$row['gender']."</td>";
										echo '<td><div class="row">
												<a href="record_attendance.php?member_id='.$row['member_id'].'&status=present&id='.$_GET['id'].'" class="btn btn-sm btn-success col-2">P</a> &nbsp	
												<a href="record_attendance.php?member_id='.$row['member_id'].'&status=absent&id='.$_GET['id'].'" class="btn btn-sm btn-danger col-2">A</a> &nbsp	
												<a href="record_attendance.php?member_id='.$row['member_id'].'&status=late&id='.$_GET['id'].'" class="btn btn-sm btn-info col-2">L</a>
											</div></td>';
										echo "</tr>";
					    		}
					    	}else{
					    		echo "<tr>";
					    		echo "<td colspan='4' class='text-center'>No Data Found</td>";
					    		echo "</tr>";
					    	}
					    ?>
					  </tbody>
					</table>
	            		</div>
	            		<div class="col-6">
	            			<table class="table table-dark table-striped table-sm">
					  <thead>
					    <tr>
					      <th scope="col">Student</th>
					      <th scope="col" style="width: 20%;">Status</th>
					    </tr>
					  </thead>
					  <tbody>
					    <?php
					    	
					    	$query = mysqli_query($conn, "SELECT * FROM `tbl_class_member` cm left join tbl_student s on cm.student_id = s.student_id LEFT JOIN tbl_attendance a ON cm.`member_id` = a.member_id WHERE cm.`class_id` = '".$_GET['id']."' AND att_date LIKE '%".date('Y-m-d')."%' order BY student_grade,student_section,gender, student_name");
					    	if (mysqli_num_rows($query) > 0) {
					    		while ($row = mysqli_fetch_assoc($query)) { 
					    		echo "<tr>";
					    		echo "<td>".$row['student_name']."</td>";
					    		if ($row['att_status'] == 'absent') {
					    			echo "<td class='text-danger'>".$row['att_status']."</td>";
					    		}else{
					    			echo "<td class='text-success'>".$row['att_status']."</td>";
					    		}
					    		echo "</tr>";
					    		}
					    	}else{
					    		echo "<tr>";
					    		echo "<td colspan='3' class='text-center'>No Data Found</td>";
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