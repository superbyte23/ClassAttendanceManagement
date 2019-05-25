<?php require 'include/header.php';
include 'include/config.php';
if (isset($_POST['addclass'])) {
		$student_id = $_POST['student_id'];

		$check_student = mysqli_query($conn,"SELECT * FROM `tbl_class_member` WHERE `class_id` = ".$_GET['id']." AND `student_id` = '$student_id' ");
		if (mysqli_num_rows($check_student)>0) {
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
  <body class="">
    <div class="page">
      	<div class="page-main">
        <?php require 'include/topbar.php'; ?> 
	        <div class="my-3 my-md-5">
	          	<div class="container">	            	
	            	<?php include 'class_menu.php'; ?>
	            	<div class="row">
	            		<div class="col-6">
	            			<input type="text" name="search" class="form-control" placeholder="Search Name" id="search">
	            			<table class="table table-striped table-sm" id="class_table">
					  
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
	            			<input type="text" name="search" class="form-control" placeholder="Search Name" id="search2">
	            			<table class="table table-striped table-sm" id="class_table2">
					  <!-- <thead>
					    <tr>
					    	<th>ID</th>
						    <th scope="col">Student</th>
						    <th scope="col" style="width: 20%;">Status</th>
					    </tr>
					  </thead> -->
					  <tbody id="search_date">
					    <?php
					    	
					    	$query = mysqli_query($conn, "SELECT * FROM `tbl_class_member` cm left join tbl_student s on cm.student_id = s.student_id LEFT JOIN tbl_attendance a ON cm.`member_id` = a.member_id WHERE cm.`class_id` = '".$_GET['id']."' AND att_date LIKE '%".date('Y-m-d')."%' order BY student_grade,student_section,gender, student_name");
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

			$(function(){
				$('#search').keyup(function() {
				  	var value = $(this).val().toLowerCase();
				    $("#class_table tr").filter(function() {
				      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
				    });
				});
			});

			$(function(){
				$('#search2').keyup(function() {
				  	var value = $(this).val().toLowerCase();
				    $("#class_table2 tr").filter(function() {
				      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
				    });
				});
			});

			// $("#date").on('change', function(){
			// 	var date = $(this).val();
			// 	alert(date);
			// })
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