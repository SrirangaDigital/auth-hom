<script type="text/javascript"> $(document).ready(function() { $( "#passwordResetForm" ).submit(submitPasswordResetForm); }); </script>

<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-6">
			<h4 class="text-center">Forgot Password?</h4>
			<div id="result" class="hide alert alert-danger">&nbsp;</div>
			<form id="passwordResetForm" method="POST">
				<div class="form-group gap-above">
					<input required type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp" placeholder="Enter email address">
					<small id="emailHelp" class="form-text text-info">Use same email address registered with us.</small>
				</div>
				<div class="row">
    				<div class="col-12 text-center mb-3">
						<button id="submit" type="submit" class="btn btn-primary">Submit</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>