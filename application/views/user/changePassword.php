<?php header("X-Frame-Options: allow-from https://sambhashanasandesha.in/"); ?>

<script type="text/javascript">
	$(document).ready(function() {

		success_phrase = '<?=SUCCESS_PHRASE?>';
		$( "#passwordChangeForm" ).submit(submitPasswordChangeForm);

		newPassword = $('#newPassword');
		confirmPassword = $('#confirmPassword');

		newPassword.on('change', validatePassword);
		confirmPassword.on('change', validatePassword);
	});

function validatePassword(){ (newPassword.val() != confirmPassword.val()) ? confirmPassword[0].setCustomValidity("Passwords Don't Match") : confirmPassword[0].setCustomValidity(''); }
</script>

<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-6"><br />
			<div id="result" class="hide alert alert-danger">&nbsp;</div>
			<form id="passwordChangeForm" method="POST">
				<div class="form-group mt-3">
					<label for="oldPassword">Old password</label>
					<input required type="password" class="form-control" name="oldPassword" id="oldPassword" aria-describedby="oldPassword" placeholder="Enter old password"><br />
					<label for="newPassword">New password</label>
					<input required type="password" class="form-control" name="newPassword" id="newPassword" aria-describedby="newPassword" placeholder="Enter new password"><br />
					<label for="confirmPassword">Confirm new password</label>
					<input required type="password" class="form-control" id="confirmPassword" placeholder="Confirm new password">
				</div>
				<div class="row">
    				<div class="col-12 text-center mt-4">
						<button id="submit" type="submit" class="btn btn-primary">Submit</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>