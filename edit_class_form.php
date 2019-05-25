<?php include 'include/config.php';

if (isset($_POST['id'])) {
	$sql = "SELECT * FROM tbl_class  WHERE class_id =".$_POST['id'];
	$result= mysqli_query($conn, $sql); 

	while ($row = mysqli_fetch_assoc($result)) {
		?>
			 <form action="#">
			  <div class="form-group">
			    <label for="class-name">Class Name:</label>
			    <input type="text" class="form-control" id="class-name" value="<?php echo $row['class_name']; ?>">
			  </div>
			  <div class="form-group">
			    <label for="grade-section">Grade & Section:</label>
			    <input type="text" class="form-control" id="grade-section" value="<?php echo $row['class_desc']; ?>">
			  </div>
			  <div class="form-group">
			    <label for="schedule">Schedule:</label>
			    <input type="text" class="form-control" id="schedule" value="<?php echo $row['class_schedule']; ?>">
			  </div>
			  <div class="form-group">
			    <label for="class-name">Class Room:</label>
			    <input type="text" class="form-control" id="class-name" value="<?php echo $row['class_room']; ?>">
			  </div>
			  <div class="form-group">
			    <label for="class-name">School Year:</label>
			    <input type="text" class="form-control" id="class-name" value="<?php echo $row['SY']; ?>">
			  </div>
			  <div class="float-right">
			  	<button type="submit" class="btn btn-success">Update</button>
			  	<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
			  </div>
			</form> 
		<?php
	}
}
?>