<?php require 'include/header.php';

include 'include/config.php';
if (isset($_POST['addclass'])) {
		$class_name = $_POST['class_name'];
		$desc = $_POST['desc'];
		$room = $_POST['room'];
		$days = $_POST['days'];
		$time = $_POST['time'];
		$schedule = $days.' | '.$time;
		$sy = $_POST['sy'];
		$instructor = $_SESSION['user_id'];

		$query = "INSERT INTO `tbl_class`(`instructor`, `class_name`, `class_schedule`, `class_desc`, `class_room`, `SY`) VALUES ('".$instructor."','$class_name', '$schedule','$desc','$room','$sy')";

		$result = mysqli_query($conn, $query);

		if ($result) {
			header("location: class_management.php?success");
		}else{
			header("location: class_management.php?error");
		}
	}
?> 
  <body class="">
    <div class="page">
      	<div class="page-main">
        <?php require 'include/topbar.php'; ?> 
	        <div class="my-3 my-md-5">
	          	<div class="container">
	          		<div class="row">
	          			<div class="col-lg-3">
	          <button class="btn btn-block btn-success" id="shadow" data-toggle="modal" data-target="#add_class" style="margin-bottom: 10px;"> Add Class</button>
	          			</div>
	          			<div class="col-lg-9">
	          				<input type="text" name="search" class="form-control" placeholder="Search Name" id="search">
	          			</div>
	          		</div>
	            	<table class="table table-dark table-sm" id="class_table" style="font-size: 15px;">
					  <thead>
					    <tr>
					      <th scope="col">#</th>
					      <th scope="col">Class Name</th>
					      <th scope="col">Grade & Section</th>
					      <th scope="col">Schedule</th>
					      <th scope="col">Action</th>
					    </tr>
					  </thead>
					  <tbody>
					    <?php 
					    	$query = mysqli_query($conn, "SELECT * FROM `tbl_class` WHERE `instructor` = '".$_SESSION['user_id']."' ORDER BY `class_schedule`");
					    	if (mysqli_num_rows($query) > 0) {
					    		while ($row = mysqli_fetch_assoc($query)) {
					    		echo "<tr>";
					    		echo "<td>".$row['class_id']."</td>";
					    		echo "<td><a href='class.php?id=".$row['class_id']."'>".$row['class_name']."</a></td>";
					    		echo "<td>".$row['class_desc']."</td>";
					    		echo "<td>".$row['class_schedule']."</td>";
					    		echo "<td>

					    		<a href='#' class='no-style'><i class='fe fe-eye'></i></a>
					    		<a href='#' class='no-style class_edit' data-toggle='modal' data-target='#edit_class' data-index='".$row['class_id']."'><i class='fe fe-edit'></i></a>
					    		<a href='#' class='no-style delete'><i class='fe fe-trash'></i></a>

					    		</td>";
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
<div class="modal fade" id="add_class" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add Class</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        </button>
      </div>

	     <form method="POST" action="">
      <div class="modal-body">
		  <div class="form-group">
		    <label for="formGroupExampleInput">Class Name (Subject Name)</label>
		    <input type="text" class="form-control" placeholder="Name" name="class_name" required="">
		  </div>
		  <div class="form-group">
		    <label>Grade & Section</label>
		    <textarea  class="form-control" name="desc" placeholder="Description" required=""></textarea>
		  </div>
		  
			<label for="formGroupExampleInput">Schedule</label>
		  	<div class="row">
			    <div class="col-6">
			    	<div class="form-group">
			    		<select name="days" class="form-control custom-select">
                          <option value="">Select Schedule</option>
                          <option value="MW">MW</option>
                          <option value="TTH">TTH</option>
                          <option value="Friday">Friday</option>
                          <option value="Saturday">Saturday</option>
                          <option value="Sunday">Sunday</option>
                        </select>
			    	</div>
			    </div>
			    <div class="col-6">
			    	<div class="form-group">
			    		<input type="text" class="form-control" placeholder="Time" name="time" required="">
			    	</div>
		    	</div>
		  </div>
		 <div class="form-group">
	      <label for="inputState">Room Number</label>
	      <select id="inputState" class="form-control" required="" name="room">
	        <option selected value="1">Genio Lab</option>
	      </select>
	    </div>
			  <div class="form-group">
	      <label for="inputState">School Year</label>
	      <select id="inputState" class="form-control" required="" name="sy">
	        <option selected value="1">2018-2019</option>
	      </select>
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
<div class="modal fade" id="edit_class">
	<div class="modal-dialog">
	    <div class="modal-content">

	      <!-- Modal Header -->
	      <div class="modal-header bg-info">
	        <h4 class="modal-title text-white"><i class="fe fe-edit"></i> Edit Class</h4>
	        <button type="button" class="close" data-dismiss="modal"></button>
	      </div>

	      <!-- Modal body -->
	      <div class="modal-body" id="result">
	        
	      </div> 
    	</div>
  	</div>
</div>
<style type="text/css">
	.no-style:hover{
		text-decoration: none;
		color:red;
	}
</style>

<script type="text/javascript" src="assets/js/vendors/jquery-3.2.1.min.js"></script>
<script>
	$(document).ready(function() {
		$(function(){
				$('#search').keyup(function() {
				  	var value = $(this).val().toLowerCase();
				    $("#class_table tr").filter(function() {
				      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
				    });
				});
			});
		$('a.class_edit').click(function(){
			var id = $(this).data('index'); 			
			if (id) {
				$.ajax({
                type:'POST',
                url:'edit_class_form.php',
                data:{id:id},
                success:function(html){
                	$('#result').html(html);
                }
            	});
			}
		});
	}); 
			
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

<script type="text/javascript">
    $('.delete').on('click', function(){
        $.confirm({
            title: 'Confirm!',
            content: 'Confirm Delete.',
            theme: 'Material',
            buttons: { 
	            Delete: {
	                btnClass: 'btn-danger custom-class', 
	            },	            
	            Cancel: {
	                btnClass: 'btn-info',
	            }
	        }
        });
    });
</script>
  </body>
</html>