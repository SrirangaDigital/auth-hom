<script type="text/javascript">
$(document).ready(function() {
	
	success_phrase = '<?=SUCCESS_PHRASE?>';
	$.get( base_url + "api/confirmResetPasswordValidity?s=" + "<?=$data['selector']?>" + "&t=" + "<?=$data['token']?>", function( data ) {
	 
		if(data !== success_phrase) {

			$("#result").html( data ).removeClass('hide');
			$('#submit').html('Submit').prop('disabled', false);
			$('#getResetPasswordForm input').prop('disabled', true);
			$('#submit').prop('disabled', true);
		}
	});

	password = $('#password');
	confirmPassword = $('#confirmPassword');

	password.on('change', validatePassword);
	confirmPassword.on('change', validatePassword);

	$( "#getResetPasswordForm" ).submit(submitgetResetPasswordForm);
});

function validatePassword(){ (password.val() != confirmPassword.val()) ? confirmPassword[0].setCustomValidity("Passwords Don't Match") : confirmPassword[0].setCustomValidity(''); }

</script>
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-6">
			<h3 class="text-center">Password reset facility</h3>
			<div id="result" class="hide alert alert-danger">&nbsp;</div>
			<form id="getResetPasswordForm" method="POST">
				<div class="form-group">
					<label for="password">New password</label>
					<input required type="password" class="form-control" name="password" id="password" placeholder="New password">
				</div>
				<div class="form-group">
					<label for="confirmPassword">Confirm new password</label>
					<input required type="password" class="form-control" name="confirmPassword" id="confirmPassword" placeholder="Confirm new password">
				</div>
				<input type="hidden" name="selector" id="type" value="<?=$data['selector']?>">
				<input type="hidden" name="token" id="type" value="<?=$data['token']?>">
				<div class="row">
    				<div class="col-12 text-center mb-3">
						<button id="submit" type="submit" class="btn btn-primary">Submit</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>