<?php require 'include/header.php';
include 'include/config.php';
if (isset($_POST['addquiz'])) {
	$quiz_name = $_POST['quiz_name'];
	$date_take = $_POST['date_take'];
	$no_items = $_POST['no_items'];

	try {
		$insert = mysqli_query($conn, "INSERT INTO `tbl_class_quiz`(`class_id`, `quiz_code`, `date_take`, `no_items`) VALUES ('".$_GET['id']."','$quiz_name','$date_take','$no_items')");
		if ($insert) {
			header('location: class_record.php?id='.$_GET['id']);
		}
	} catch (Exception $e) {
		echo 'Message: ' .$e->getMessage();
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
	            	<div class="h2" style="margin-top: -15px">Class Name : <?php echo $class_name; ?> | <?php echo $class_schedule; ?> | <?php echo $class_desc; ?></div>
	            	<button data-toggle="modal" data-target="#add_quiz" id="shadow" class="btn btn-success" style="margin-top: -15px; margin-bottom: 10px;">Add Quiz</button>
	            	<button id="shadow" onclick="history.back();" class="btn btn-info" style="margin-top: -15px; margin-bottom: 10px;"> Back</button>
	            	
	            	<table class="table responsive table-striped table-sm table-dark">
					  <thead>
					    <tr>
					      <th>Quiz Code</th>
					      <th>No. of Items</th>
					      <th>Date</th>
					    </tr>
					  </thead>
					  <tbody>
					      <?php
					      $quiz = mysqli_query($conn, "SELECT * FROM `tbl_class_quiz` WHERE `class_id` =".$_GET['id']);
					      if (mysqli_num_rows($quiz)>0) {
					      	while ($row = mysqli_fetch_assoc($quiz)) {
					      		echo '<tr>';
								echo '<td><a href="class_record.php?id='.$_GET['id'].'&quiz_id='.$row['id'].'">'.$row['quiz_code'].'</a></td>';
								echo '<td>'.$row['no_items'].'</td>';
								echo '<td>'.$row['date_take'].'</td>';
								echo '</tr>';
					      	}
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
<div class="modal fade" id="add_quiz" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add Quiz</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        </button>
      </div>
	     <form method="POST" action="">
	      <div class="modal-body">

			  <div class="form-group">
			    <label for="formGroupExampleInput">Quiz Name</label>
			    <input type="text" class="form-control stud_name" placeholder="Name" name="quiz_name" required="" autocomplete="off" value="">
			    </div>
			    <div class="form-group">
			    <label for="formGroupExampleInput">Date</label>
			    <input type="date" class="form-control stud_name" placeholder="Date" name="date_take"  required="" autocomplete="off" value="">
			    </div>
			    <div class="form-group">
			    <label for="formGroupExampleInput">No. of Items</label>
			    <input type="number" class="form-control stud_name" placeholder="Number of Items" name="no_items" required="" autocomplete="off" value="">
			    </div>
			  </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        <button type="submit" class="btn btn-primary" name="addquiz">Add</button>
	      </div>
		</form>
    </div>
  </div>
</div>

<div class="modal fade" id="score" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
	     <form method="POST" action="">
	      	<div class="modal-body">
			  <div class="form-group">
			    <label for="formGroupExampleInput">Score</label>
			    <input type="number" class="form-control stud_name" placeholder="Score" name="score" required="" autocomplete="off" value="">
			    <input type="text" name="student_id" id="student_id" hidden="">
			  </div>
			  <div class="form-group">
			  	<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        	<button type="submit" class="btn btn-primary" name="addquiz">Submit</button>
			  </div>
			</div>
		</form>
    </div>
  </div>
</div>
<script type="text/javascript" src="assets/js/vendors/jquery-3.2.1.min.js"></script>
<script>
	$(document).ready(function(){
		$('.score').on('click',function(){
			var id = $(this).data('index');
			$('#student_id').val(id);
		})
	})
</script>
</body>
</html>