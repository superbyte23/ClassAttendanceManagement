<?php require 'include/header.php';

if (isset($_POST['add_grade'])) {
	$grade = $_POST['grade'];
	$add_grade = mysqli_query($conn, "INSERT INTO `tbl_grade`(`grade`, `grade_desc`) VALUES ('$grade','$grade')");
	if ($add_grade) {
		header('location: grade_section.php');
	}
}elseif (isset($_POST['add_section'])) {
	$section = $_POST['section'];
	$add_section = mysqli_query($conn, "INSERT INTO `tbl_section`(`section_name`, `section_desc`) VALUES ('$section','$section')");
	if ($add_section) {
		header('location: grade_section.php');
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
	            		<div class="col-6">
	            			<form action="" method="POST">
	            				<div class="form-group">
								  <div class="input-icon mb-3">
								    <span class="input-icon-addon">
								      <i class="fe fe-box"></i>
								    </span>
								    <input type="text" class="form-control" placeholder="Add Grade" name="grade">
								  </div>
								</div>
								<input type="submit" name="add_grade" hidden="">
	            			</form>
	            			<table class="table table-dark table-sm table-striped">
							  <thead>
							    <tr>
							      <th scope="col">#</th>
							      <th scope="col">Grade</th>
							      <th style="width: 20%;">Action</th>
							    </tr>
							  </thead>
							  <tbody>
							  	<?php 
							  	$query_grade = mysqli_query($conn, "SELECT * FROM `tbl_grade`");
							  	if (mysqli_num_rows($query_grade)>0) {
							  		while ($row = mysqli_fetch_assoc($query_grade)) {
							  			echo "<tr>";
							  			echo "<td>".$row['id']."</td>";
							  			echo "<td>".$row['grade']."</td>";
							  			echo "<td><a href='' class='btn btn-danger btn-sm'><i class='fe fe-trash'></i></a> <a href='' class='btn btn-info btn-sm'><i class='fe fe-edit'></i></a></td>";
							  			echo "</tr>";
							  		}
							  	}
							  	?>
							  </tbody>
							</table>
	            		</div>
	            		<div class="col-6">
	            			<form action="" method="POST">
	            				<div class="form-group">
								  <div class="input-icon mb-3">
								    <span class="input-icon-addon">
								      <i class="fe fe-box"></i>
								    </span>
								    <input type="text" class="form-control" placeholder="Add Section" name="section">
								  </div>
								</div>
								<input type="submit" name="add_section" hidden="">
	            			</form>
	            			<table class="table table-dark table-sm table-striped">
							  <thead>
							    <tr>
							      <th scope="col">#</th>
							      <th scope="col">Section</th>
							      <th style="width: 20%;">Action</th>
							    </tr>
							  </thead>
							  <tbody>
							  	<?php 
							  	$query_grade = mysqli_query($conn, "SELECT * FROM `tbl_section`");
							  	if (mysqli_num_rows($query_grade)>0) {
							  		while ($row = mysqli_fetch_assoc($query_grade)) {
							  			echo "<tr>";
							  			echo "<td>".$row['id']."</td>";
							  			echo "<td>".$row['section_name']."</td>";
							  			echo "<td><a href='' class='btn btn-danger btn-sm'><i class='fe fe-trash'></i></a> <a href='' class='btn btn-info btn-sm'><i class='fe fe-edit'></i></a></td>";
							  			echo "</tr>";
							  		}
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
  </body>
</html>