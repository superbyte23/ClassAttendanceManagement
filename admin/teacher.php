<?php require 'include/header.php';

include 'include/config.php';
if (isset($_POST['addclass'])) {
		$class_name = $_POST['class_name'];
		$desc = $_POST['desc'];
		$room = $_POST['room'];
		$sy = $_POST['sy'];
		$instructor = $_POST['instructor'];

		$query = "INSERT INTO `tbl_class`(`instructor`, `class_name`, `class_desc`, `class_room`, `SY`) VALUES ('".$instructor."','$class_name','$desc','$room','$sy')";

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
	            	<div class="page-header">
		              	<h1 class="page-title">
		                	Manage Class <div class="row">
		             		<div class="col">
		              			<button class="btn btn-success" data-toggle="modal" data-target="#add_class"> Add Class</button>
		             		</div>
		             	</div>
		              	</h1>		             	
	            	</div>
	            	<table class="table table-dark">
					  <thead>
					    <tr>
					      <th scope="col">#</th>
					      <th scope="col">Class Name</th>
					      <th scope="col">Description</th>
					      <th scope="col">Room</th>
					      <th scope="col">S.Y.</th>
					    </tr>
					  </thead>
					  <tbody>
					    <?php 
					    	$query = mysqli_query($conn, "SELECT * FROM `tbl_class`");
					    	if (mysqli_num_rows($query) > 0) {
					    		while ($row = mysqli_fetch_assoc($query)) {
					    		echo "<tr>";
					    		echo "<td>".$row['class_id']."</td>";
					    		echo "<td><a href='class.php?id=".$row['class_id']."'>".$row['class_name']."</a></td>";
					    		echo "<td>".$row['class_desc']."</td>";
					    		echo "<td>".$row['class_room']."</td>";
					    		echo "<td>".$row['SY']."</td>";
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
		    <label for="formGroupExampleInput">Class Name (Grade - Section & Subject Name)</label>
		    <input type="text" class="form-control" placeholder="Name" name="class_name" required="">
		  </div>
		  <div class="form-group">
		    <label>Class Description</label>
		    <textarea  class="form-control" name="desc" placeholder="Description" required=""></textarea>
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
	    <div class="form-group">
	      <label for="inputState">Instructor</label>
	      <select id="inputState" class="form-control" required="" name="instructor">
	        	<?php 

	        		$ins = mysqli_query($conn, "SELECT * FROM `tbl_teacher`");
	        		if (mysqli_num_rows($ins)>0) {
	        			while ($row_ins = mysqli_fetch_assoc($ins)) {
	        				echo '<option value="'.$row_ins['teacher_id'].'">'.$row_ins['teacher_name'].'</option>';
	        			}
	        		}
	        	?>
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
  </body>
</html>