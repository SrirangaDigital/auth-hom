<?php

class api extends Controller {

	public function __construct() {
	
		parent::__construct();
	}

	public function login() {

		$postData = $this->model->getPostData();

		try {

		    $this->auth->loginWithUsername($postData['username'], $postData['password']);

		    $this->model->loadSessionVariables($postData);
    		$_SESSION['auth_roles_assigned'] = $this->auth->getRoles();

		    echo($postData['returnUrl']);
		}
		catch (\Delight\Auth\UnknownUsernameException $e) {
		    
		    echo('unknown username');
		}
		// catch (\Delight\Auth\InvalidEmailException $e) {
		    
		//     echo('wrong email address');
		// }
		catch (\Delight\Auth\InvalidPasswordException $e) {
		    
		    echo('wrong password');
		}
		catch (\Delight\Auth\EmailNotVerifiedException $e) {
		    
		    echo('email not verified');
		}
		catch (\Delight\Auth\TooManyRequestsException $e) {
		    
		    echo('too many requests');
		}
	}

	public function initiateResetPassword() {

		
		try {
				$postData = $this->model->getPostData();
				
		    	$this->auth->forgotPassword($postData['email'], function ($selector, $token) use ($postData){
					
					// Send mail
					$postData['fullName'] = $this->model->getFullname($postData['email']);
					$this->model->sendLetterToPostman($postData, DEFAULT_RETURN_URL . 'user/resetPassword?s=' . $selector . '&t=' . $token);
			    	echo SUCCESS_PHRASE;

		    	});

		}
		catch (\Delight\Auth\InvalidEmailException $e) {
		    echo ('invalid email address');
		}
		catch (\Delight\Auth\EmailNotVerifiedException $e) {
		    echo ('email not verified');
		}
		catch (\Delight\Auth\ResetDisabledException $e) {
		    echo ('password reset is disabled');
		}
		catch (\Delight\Auth\TooManyRequestsException $e) {
		    echo ('An email have been already sent to your email, Please check out');
		}
	}

	public function confirmResetPasswordValidity() {

		$getData = $this->model->getGETData();

		try {
		    $this->auth->canResetPasswordOrThrow($getData['s'], $getData['t']);

		    echo SUCCESS_PHRASE;
		}
		catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
		    echo ('invalid token');
		}
		catch (\Delight\Auth\TokenExpiredException $e) {
		    echo ('token expired');
		}
		catch (\Delight\Auth\ResetDisabledException $e) {
		    echo ('password reset is disabled');
		}
		catch (\Delight\Auth\TooManyRequestsException $e) {
		    echo ('too many requests');
		}
	}

	public function resetPassword() {

		$postData = $this->model->getPostData();
		if($postData['password'] != $postData['confirmPassword']) { echo "Passwords Don't Match"; return; }

		try {
		    $this->auth->resetPassword($postData['selector'], $postData['token'], $postData['password']);

		    echo SUCCESS_PHRASE;
		}
		catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
		    echo ('invalid token');
		}
		catch (\Delight\Auth\TokenExpiredException $e) {
		    echo ('token expired');
		}
		catch (\Delight\Auth\ResetDisabledException $e) {
		    echo ('password reset is disabled');
		}
		catch (\Delight\Auth\InvalidPasswordException $e) {
		    echo ('invalid password');
		}
		catch (\Delight\Auth\TooManyRequestsException $e) {
		    echo ('too many requests');
		}
	}

	public function register() {

		$postData = $this->model->getPostData();
		$postData['email'] = '';

		try {

		    $userId = $this->auth->admin()->createUserWithUniqueUsername($_POST['email'], $_POST['password'], $_POST['username']);
		    // $this->model->insertUserDetails($postData);
		    echo $postData['returnUrl'];

		}
		catch (\Delight\Auth\InvalidEmailException $e) {
		    echo 'invalid email address';
		}
		catch (\Delight\Auth\InvalidPasswordException $e) {
		    echo 'invalid password';
		}
		catch (\Delight\Auth\UserAlreadyExistsException $e) {
		    echo 'user already exists';
		}
		catch (\Delight\Auth\DuplicateUsernameException $e) {
		    echo 'username not unique';
		}
	}

	public function confirmEmail() {

		$selector = 'v4NBLJuEHRuyXDvU';
		$token = "6MbPmChc_LrYpX9d";

		try {
		    $this->auth->confirmEmail($selector, $token);

		    echo('email address has been verified');
		}
		catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
		    
		    echo('invalid token');
		}
		catch (\Delight\Auth\TokenExpiredException $e) {
		    
		    echo('token expired');
		}
		catch (\Delight\Auth\UserAlreadyExistsException $e) {
		    
		    echo('email address already exists');
		}
		catch (\Delight\Auth\TooManyRequestsException $e) {
		    
		    echo('too many requests');
		}
	}

	public function logout() {

		try {
		    $this->auth->logOutEverywhere();
		    $this->auth->destroySession();
		}
		catch (\Delight\Auth\NotLoggedInException $e) {

		    echo 'Not logged in';
		}
	}

	public function changePassword() {

		$postData = $this->model->getPostData();

		try {

		    $this->auth->changePassword($postData['oldPassword'], $postData['newPassword']);

		    echo SUCCESS_PHRASE;
		}
		catch (\Delight\Auth\NotLoggedInException $e) {
		
			echo('Not logged in');
		}
		catch (\Delight\Auth\InvalidPasswordException $e) {
			
			echo('Old password not matching');
		}
		catch (\Delight\Auth\TooManyRequestsException $e) {
			
			echo('Too many requests');
		}
	}

	public function createAdmin() {

		$adminEmail = 'books@sriranga.digital';
		$adminPassword = 'B00k5MysH15';
		$adminUsername = 'admin';
		
		try {
		    $userId = $this->auth->admin()->createUserWithUniqueUsername($adminEmail, $adminPassword, $adminUsername);
		}
		catch (\Delight\Auth\InvalidEmailException $e) {
		    echo 'Invalid email address';
		}
		catch (\Delight\Auth\InvalidPasswordException $e) {
		    echo 'Invalid password';
		}
		catch (\Delight\Auth\UserAlreadyExistsException $e) {
		    echo 'User already exists';
		}
		catch (\Delight\Auth\DuplicateUsernameException $e) {
		    echo 'Username not unique';
		}

		try {
		    $this->auth->admin()->addRoleForUserByEmail($adminEmail, \Delight\Auth\Role::ADMIN);
		}
		catch (\Delight\Auth\InvalidEmailException $e) {
		    die('Unknown email address');
		}

	}


}
?>
