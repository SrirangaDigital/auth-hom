<?php

class View {

	public function __construct() {

	}
	
	public function getActualPath($path = '', $folderList = array()) {

		$pathRegex = str_replace('/', '\/[0-9]+\-*', $path) . '$';
		$pathMatched = array_values(preg_grep("/$pathRegex/", $folderList));
		
		if(isset($pathMatched[0])) {

			return str_replace(PHY_FLAT_URL, 'flat/', $pathMatched[0]);
		}
		else{

			// Second pass to check whether the path is pointing to a file other than index in a given folder
			$pathArray = preg_match('/(.*)\/(.*)/', $path, $matches);
			$secondTry = $matches[1];
			$suffix = $matches[2];

			$pathRegex = str_replace('/', '\/[0-9]+\-*', $secondTry) . '$';
			$pathMatched = array_values(preg_grep("/$pathRegex/", $folderList));

			return (isset($pathMatched[0])) ? str_replace(PHY_FLAT_URL, 'flat/', $pathMatched[0]) . '/' . $suffix : '';
		}
	}

	public function getNavigation($path = '') {

		// Include only folders beginning with a number
		$dirs = glob($path . '[0-9]*', GLOB_ONLYDIR);
		natsort($dirs);
		
		if(!(empty($dirs))) {
			
			foreach ($dirs as $key => $value) {

				$subNav = $this->getNavigation($value . '/');
				if($subNav) {

					$dirs{$key} = array($value);
					array_push($dirs{$key}, $subNav);
				}
			}
			return $dirs;
		}
	}

	public function getFolderList($navigation = array()) {

		$folderList = array();
		$iterator = new RecursiveIteratorIterator(new RecursiveArrayIterator($navigation));
		foreach($iterator as $value) {
  			array_push($folderList, $value);
		}
		return $folderList;
	}

	public function showDynamicPage($data = array(), $path = '', $actualPath = '', $navigation = array()) {

		require_once 'application/views/viewHelper.php';
		$viewHelper = new viewHelper();
		$pageTitle = $this->getPageTitle($viewHelper, $path);

		require_once 'application/views/header.php';
		
		// if(preg_match('/flat\/Home/', $path)) require_once 'application/views/carousel.php';
		
		if(file_exists('application/views/' . $actualPath . '.php')) {
		    require_once 'application/views/' . $actualPath . '.php';
		}
		elseif(file_exists('application/views/' . $actualPath . '/index.php')) {
		    require_once 'application/views/' . $actualPath . '/index.php';
		}
		else{
		    require_once 'application/views/error/index.php';
		}

		// require_once 'application/views/generalSidebar.php';
		require_once 'application/views/footer.php';
	}

	public function showFlatPage($data = array(), $path = '', $actualPath = '', $navigation = array()) {

		require_once 'application/views/viewHelper.php';
		$viewHelper = new viewHelper();
		$pageTitle = $this->getPageTitle($viewHelper, $path);

		require_once 'application/views/header.php';
		require_once 'application/views/flatPageContainer.php';
		// require_once 'application/views/generalSidebar.php';
		require_once 'application/views/footer.php';
    }

    public function printNavigation($navigation = array(), $ulClass = ' class="nav navbar-nav navbar-right"', $liClass = ' class="dropdown"') {

        echo '<ul' . $ulClass . '>' . "\n";
        foreach ($navigation as $mainNav) {
 			
 			// Trailing '/' is appended to href links, as GLOB_MARK is not added in getNavigation method

            if(is_array($mainNav)){

                echo "\t" . '<li' . $liClass . '>' . "\n";
                echo "\t\t" . '<a href="' . $this->getNavLink($mainNav[0]) . '/" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">' . $this->processNavPath($mainNav[0]) . ' <span class="caret"></span></a>' . "\n";
                $this->printNavigation($mainNav[1], ' class="dropdown-menu" role="menu"', ' class="dropdown"');
                echo "\t" . '</li>' . "\n";
            }
            else{
            	
            	$anchorText = $this->processNavPath($mainNav);
                if($anchorText) {
                	
                	$isExternal = $this->checkIfExternal($mainNav);
                	$targetBlank = ($isExternal['type'] == 'OutsideDomain') ? 'target="_blank" ' : '';
                	$navLink = $this->getNavLink($mainNav) . '/';

                	if($isExternal){
                		
                		$navLink = $isExternal['URL'];
                		if($isExternal['type'] == 'InsideDomain') $navLink = BASE_URL . $navLink;
                	}
                	echo "\t" . '<li><a ' . $targetBlank . 'href="' . $navLink . '">' . $anchorText . '</a></li>' . "\n";
                }
                else{

                	echo "\t" . '<li role="separator" class="divider"></li>' . "\n";
                }
            }
        }
        echo '</ul>' . "\n";
    }

    private function checkIfExternal($path) {

    	$linkPath = $path . '/link.php';
    	if(file_exists($linkPath)) {

    		$handle = fopen($linkPath, 'r');
 	    	$externalURL['URL'] = fgets($handle);
 	    	$externalURL['type'] = (preg_match('/^http|www/', $externalURL['URL'])) ? 'OutsideDomain' : 'InsideDomain';
 	    	return $externalURL;
    	}
    	return False;
    }

	private function printBreadcrumb($path) {

    	$path = preg_replace('/flat/', 'Home', $path);
    	$path = preg_replace('/\_/', ' ', $path);
    	$pathItems = explode('/', $path);

    	echo '<ol class="breadcrumb">';
        foreach ($pathItems as $item) {

        	echo '<li>' . $item . '</li>';
        }
        echo '</ol>';

    }

    private function processNavPath($path) {

        $path = preg_replace('/\/[0-9]+\-/', '/', $path);
        $path = explode('/', $path);
        $path = htmlentities(str_replace('_', ' ', $path[count($path) - 1]), ENT_COMPAT, "UTF-8");
    	// Letters which are to be forced to lower-case need to handled below
    	return preg_replace('/IASc/', 'IAS<span class="lower-case">c</span>', $path);
    }

    private function getNavLink($path) {

        $path = preg_replace('/\/[0-9]+\-/', '/', $path);
        return htmlentities(str_replace(PHY_FLAT_URL, BASE_URL, $path), ENT_COMPAT, "UTF-8");
    }
	
	private function getPageTitle($viewHelper, $path) {

		if(preg_match('/flat/', $path)){

			// Remove trailing slashes
			$path = preg_replace('/\/$/', '', $path);
			$paths = explode('/', $path);
			// Remove 'flat' from the URL
			unset($paths[0]);
			$paths = array_reverse($paths);
			$paths = array_unique($paths);
			$pageTitle = implode(' | ', $paths);
			return preg_replace('/_/', ' ', $pageTitle);
		}
		else{

			return '';
		}
    }
}

?>