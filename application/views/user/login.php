<script type="text/javascript">

$(document).ready(function() {

	$( ".trigger" ).on('click', function(){

		$(".trigger").removeClass('orange');

		if($(this).attr('id') == 'signIn'){

			$('#signUpForm').hide();
			$('#signInForm').show();
			$('#signIn').addClass('orange');
		}
		else {

			$('#signInForm').hide();
			$('#signUpForm').show();
			$('#signUp').addClass('orange');
		}
	});

	var getInType = '<?=$data['type']?>';
	
	if(getInType == 'in')
		$( "#signIn" ).trigger( "click" );
	else
		// Show Registration form by default
		$( "#signUp" ).trigger( "click" );


	$( "#signUpForm" ).submit(submitRegisterForm);
	$( "#signInForm" ).submit(submitLoginForm);

	password = $('#password');
	confirmPassword = $('#confirmPassword');

	password.on('change', validatePassword);
	confirmPassword.on('change', validatePassword);

	email = $('#email');
	confirmEmail = $('#confirmEmail');

	email.on('change', validateEmail);
	confirmEmail.on('change', validateEmail);
});

// Validate Email
function validateEmail(){ (email.val() != confirmEmail.val()) ? confirmEmail[0].setCustomValidity("Emails do not match") : confirmEmail[0].setCustomValidity(''); }

// Validate password
function validatePassword(){ (password.val() != confirmPassword.val()) ? confirmPassword[0].setCustomValidity("Passwords do not match") : confirmPassword[0].setCustomValidity(''); }
</script>

<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-6">
			<div class="row mb-4">
				<!-- <div class="col-6 custom text-center">
					<h5><a class="trigger" id="signUp">Sign Up</a></h5>
				</div> -->
				<div class="col-6 custom text-center">
					<h5><a class="trigger orange" id="signIn">Sign In</a></h5>
				</div>
			</div>
			<form class="input-form hide" id="signUpForm" method="POST">
				<div id="result" class="hide alert alert-danger">&nbsp;</div>
				<div class="form-group">
					<input required type="text" class="form-control" name="username" id="fullname" aria-describedby="fullnameHelp" placeholder="User Name">
					<!-- <small id="fullnameHelp" class="form-text text-muted">Full name.</small> -->
				</div>
				<div class="form-group">
					<input required type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp" placeholder="Email">
					<!-- <small id="emailHelp" class="form-text text-muted">Email address for registration.</small> -->
				</div>
				<div class="form-group">
					<input required type="email" class="form-control" id="confirmEmail" aria-describedby="emailHelp" placeholder="Confirm email">
					<!-- <small id="emailHelp" class="form-text text-muted">Email address for registration.</small> -->
				</div>
				<div class="form-group">
					<input required type="password" class="form-control" name="password" id="password" placeholder="Password">
					<!-- <small id="passwordHelp" class="form-text text-muted">Password</small> -->
				</div>
				<div class="form-group">
					<input required type="password" class="form-control" id="confirmPassword" placeholder="Confirm Password">
					<!-- <small id="passwordHelp" class="form-text text-muted">Password</small> -->
				</div>
				<input type="hidden" name="returnUrl" id="returnUrl" value="<?=DEFAULT_RETURN_URL?>"><br />
				<div class="row">
    				<div class="col-12 text-center">
						<button id="submit" type="submit" class="btn">Register</button>
					</div>
				</div>
			</form>
			<form class="input-form" id="signInForm" method="POST">
				<div id="lresult" class="hide alert alert-danger">&nbsp;</div>
				<div class="form-group">
					<!-- <label for="lemail">Email</label> -->
 					<input required type="text" class="form-control" name="username" id="username" aria-describedby="userNameHelp" placeholder="User Name">
					<!-- <small id="emailHelp" class="form-text text-muted">Registered Email.</small> -->
				</div>
				<div class="form-group">
					<!-- <label for="lpassword">Password</label> -->
					<input required type="password" class="form-control" name="password" id="password" placeholder="Password">
					<small id="forgotPasswordHelp" class="text-right form-text text-muted"><a href="<?=BASE_URL?>user/resetPassword">Forgot password?</a></small>
				</div>
				<input type="hidden" name="type" id="type" value="<?=$data['type']?>">
				<input type="hidden" name="returnUrl" id="returnUrl" value="<?=$data['returnUrl']?>">
				<div class="row">
    				<div class="col-12 text-center">
						<button id="lsubmit" type="submit" class="btn">Login</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
