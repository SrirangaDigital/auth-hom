<?php

class user extends Controller {

	public function __construct() {
	
		parent::__construct();
	}

	public function testSession() {

		var_dump($_SESSION);
	}
	
	public function login($query = [], $type = '') {

		$data['returnUrl'] =  DEFAULT_RETURN_URL;
		$data['type'] = DEFAULT_GETIN_TYPE;

		$this->view('user/login', $data);
	}

	public function logout($query = []) {

		// Ideally this work should be done by the api, due to lack of inheritance, it is done here for now.
		$data['returnUrl'] = isset($query['returnUrl']) ? $query['returnUrl'] : DEFAULT_RETURN_URL;
		try {
		    $this->auth->logOutEverywhere();
		    $this->auth->destroySession();
		}
		catch (\Delight\Auth\NotLoggedInException $e) {

		    echo 'Not logged in';
		}

		$this->absoluteRedirect($data['returnUrl']);
	}

	public function resetPassword() {

		$this->view('user/resetPasswordEmail');
	}

	public function getResetPassword($query = []) {

		if(!isset($query['s']) || !isset($query['t'])) { $this->view('error/blah'); return;}

		$data['selector'] = $query['s'];
		$data['token'] = $query['t'];

		$this->view('user/getResetPassword', $data);
	}

	public function changePassword() {

		$this->view('user/changePassword');
	}
}

?>
