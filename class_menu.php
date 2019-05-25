<div class="alert alert-success"  style="margin-top: -15px">
	            		<?php echo $class_desc; ?> : <?php echo $class_name; ?> 
	            	</div>
<div style="padding-right: 20px; padding-bottom: 10px;"> 
            			<a href="class.php?id=<?php echo $_GET['id']; ?>" id="shadow" class="btn btn-success">Check Attendance</a> 
                        <a href="attendance.php?id=<?php echo $_GET['id']; ?>" id="shadow" class="btn btn-danger">Attendance Record</a>
                        <a href="grades.php?id=<?php echo $_GET['id']; ?>" id="shadow" class="btn btn-success">Grades</a> 

                        <input type="date" name="date" id="date" class="form-control" placeholder="Select Date">
                        <button data-toggle="modal" id="shadow" data-target="#add_student" class="btn btn-info" >Add Student</button>
	            	</div>