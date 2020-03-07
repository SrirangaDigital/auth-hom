function submitRegisterForm(event){

	event.preventDefault();

	$('#submit').html('<i class="fa fa-spinner fa-spin"></i>').prop('disabled', true);
	
	$.post( base_url + "api/register", $('#signUpForm').serialize(), function( data ) {
		
		if(data.match(/^http[s]*:\/\/.*\/$/)) {

			window.top.location.href = data;
		}
		else{

			$( "#result" ).html( data ).removeClass( 'hide' );
			$('#submit').html('Submit').prop('disabled', false);
		}
	});
}

function submitLoginForm(event){

	event.preventDefault();

	$('#lsubmit').html('<i class="fa fa-spinner fa-spin"></i>').prop('disabled', true);
	
	$.post( base_url + "api/login", $('#signInForm').serialize(), function( data ) {
	 	
		if(data.match(/^http[s]*:\/\/.*\/$/)) {

			window.top.location.href = data;
		}
		else{

			$( "#lresult" ).html( data ).removeClass( 'hide' );
			$('#lsubmit').html('Submit').prop('disabled', false);
		}
	});
}

function submitPasswordResetForm(event){

	event.preventDefault();

	$('#submit').html('<i class="fa fa-spinner fa-spin"></i>').prop('disabled', true);
	
	$.post( base_url + "api/initiateResetPassword", $('#passwordResetForm').serialize(), function( data ) {
	 
		if(data === success_phrase){

			$( "#result" ).html( 'An email has been sent to your address. Follow the link there to reset password.').removeClass('alert-danger').addClass('alert-success').removeClass( 'hide' );
		}	
		else{

			$( "#result" ).html( data ).removeClass( 'hide' );
		}

		$('#submit').html('Submit').prop('disabled', false);
	});
}

function submitgetResetPasswordForm(event){

	event.preventDefault();

	$('#submit').html('<i class="fa fa-spinner fa-spin"></i>').prop('disabled', true);
	
	$.post( base_url + "api/resetPassword", $('#getResetPasswordForm').serialize(), function( data ) {
	 
		$('#submit').html('Submit').prop('disabled', false);
		$( "#result" ).html( data ).removeClass( 'hide' );

		if(data === success_phrase) {

			$( "#result" ).html( 'Password successfully reset.' ).removeClass('alert-danger').addClass('alert-success');
			$("#getResetPasswordForm").hide();
		}
	});
}

function submitPasswordChangeForm(event){

	event.preventDefault();

	$('#submit').html('<i class="fa fa-spinner fa-spin"></i>').prop('disabled', true);
	
	$.post( base_url + "api/changePassword", $('#passwordChangeForm').serialize(), function( data ) {
	 
		$('#submit').html('Submit').prop('disabled', false);
		$( "#result" ).html( data ).removeClass( 'hide' );

		if(data === success_phrase) {

			$( "#result" ).html( 'Password successfully changed.' ).removeClass('alert-danger').addClass('alert-success');
			$("#passwordChangeForm").hide();
		}
	});
}