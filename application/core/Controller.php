<?php

class Controller {

	public function __construct() {

		$this->db = new Database();
		$this->dbh = $this->db->connect(DB_NAME);
		$this->auth = new \Delight\Auth\Auth($this->dbh);
	}

	public function loadModel($model) {

		$path = 'application/models/' . $model . '.php';

		if(file_exists($path)) {

			require_once $path;
			return new $model();
		}
	}
	
	public function view($path, $data = array()) {

		$view = new View();
		$model = new Model();
	
		// Get Navigation array in nested form	
		$navigation = $view->getNavigation(PHY_FLAT_URL);
		// Get folder list in flat form
		$folderList = $view->getFolderList($navigation);
		// Get actual path void of sorting numbers
		$actualPath = $view->getActualPath($path, $folderList);
		// Actual path is given path for dynamic pages
		if(!($actualPath)) $actualPath = $path;
		// Show Page
		(preg_match('/flat\/[^Home]|error|prompt/', $path)) ? $view->showFlatPage($data, $path, $actualPath, $navigation) : $view->showDynamicPage($data, $path, $actualPath, $navigation);
	}

	public function redirect($path) {

		@header('Location: ' . BASE_URL . $path);
	}

	public function absoluteRedirect($path) {

		@header('Location: ' . $path);
	}
}

?>