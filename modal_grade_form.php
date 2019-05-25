<div class="modal fade" id="edit_grade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Update Grade</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        </button>
      </div>
	     <form method="POST" action="">
	      <div class="modal-body">
	      	<div class="form-group">
		      	<!-- <label class="form-label">First Grading</label> -->
		      	<input type="number" name="1st" class="form-control" placeholder="First Grading" maxlength="100">
	      	</div>
	      	<div class="form-group">
		      	<!-- <label class="form-label">Second Grading</label> -->
		      	<input type="number" name="2nd" class="form-control" placeholder="Second Grading" maxlength="100">
	      	</div>
	      	<div class="form-group">
		      	<!-- <label class="form-label">Third Grading</label> -->
		      	<input type="number" name="3rd" class="form-control" placeholder="Third Grading" maxlength="100">
	      	</div>
	      	<div class="form-group">
		      	<!-- <label class="form-label">Fourth Grading</label> -->
		      	<input type="number" name="4th" class="form-control" placeholder="Fourth Grading" maxlength="100">
	      	</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
	        <button type="submit" class="btn btn-primary" name="addclass">Update</button>
	      </div>

		</form>
    </div>
  </div>
</div>