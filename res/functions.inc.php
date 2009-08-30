<?php
/**
 * Function to turn the triggered errors into exceptions
 * @author troelskn at gmail dot com
 * @see http://php.net/manual/en/class.errorexception.php
 * @param $severity
 * @param $message
 * @param $filename
 * @param $lineno
 * @throws vscExceptionError
 * @return void
 */
function exceptions_error_handler ($iSeverity, $sMessage, $sFilename, $iLineNo) {
	if (error_reporting() == 0) {
		return;
	}

	if (error_reporting() & $iSeverity) {
		// the __autoload seems not to be working here
		import ('coreexceptions');
		if (!class_exists ('vscExceptionError')) {
			include_once ('vscexceptionerror.class.php');
		}
		throw new vscExceptionError ($sMessage, 0, $iSeverity, $sFilename, $iLineNo);
	}
}

/**
 * @return bool
 */
function isCli () {
	return (php_sapi_name() == 'cli');
}

/**
 * returns an end of line, based on the environment
 * @return string
 */
function nl () {
	return isCli() ? "\n" : '<br/>' . "\n";
}

/**
 * Removes all extra spaces from a string
 * @param string $s
 * @return string
 */
function alltrim ($s) {
	return trim (preg_replace('/\s+/', ' ', $s));
}

function d () {
	$aRgs = func_get_args();
	$iExit = 1;

	for ($i = 0; $i < ob_get_level(); $i++) {
		// cleaning the buffers
		ob_end_clean();
	}

	if (!isCli()) {
		// not running in console
		echo '<pre>';
	}

	foreach ($aRgs as $object) {
		// maybe I should just output the whole array $aRgs
		var_dump($object);
	}

	if (!isCli()) {
		// not running in console
		echo '</pre>';
	}
	exit ();
}


/**
 * the __autoload automagic function for class initialisation,
 * @param string $className
 */
function __autoload ($className) {
	if (class_exists ($className, false))  {
		return true;
	}

	$classNameLow = strtolower($className);

	$sFilePath	= $classNameLow . '.class.php';
	$fileIncluded = @include ($sFilePath);
	if ( !$fileIncluded ) {
		$sFilePath = $classNameLow . DIRECTORY_SEPARATOR . $sFilePath;
		$fileIncluded = @include ($sFilePath);
	}

	if (!$fileIncluded) {
		import ('coreexceptions');
		include_once ('vscexceptionautoload.class.php');
		throw new vscExceptionAutoload('Could not load class ['.$className.'] in path: ' . get_include_path());
	} else {
		return true;
	}
}

if (!function_exists('import')){
	/**
	 * Adds the package name to the include path
	 * @todo make sure that the path isn't aleady in the include path
	 * @param string $sIncPath
	 * @return bool
	 * @throws vscExceptionPackageImport
	 */

	function import ($sIncPath) {
		$pkgLower 	= strtolower ($sIncPath);
		$pkgPath	= LIB_PATH . $pkgLower . DIRECTORY_SEPARATOR;

		$path 		= get_include_path();
		if (is_dir ($pkgPath)) {
			if (strpos ($path, $pkgPath . PATH_SEPARATOR) === false) {
				// adding exceptions dir to include path if it exists
				if (is_dir ($pkgPath. DIRECTORY_SEPARATOR . 'exceptions')) {
					// adding the exceptions if they exist
					$pkgPath .= PATH_SEPARATOR . $pkgPath . DIRECTORY_SEPARATOR . 'exceptions';
				}
				set_include_path (
					$pkgPath . PATH_SEPARATOR .
					$path
				);
			}

			return true;
		} elseif ($pkgLower != 'coreexceptions') {
			import ('coreexceptions');
			include_once ('vscexceptionpackageimport.class.php');
			throw new vscExceptionPackageImport ('Bad package "' . $sIncPath . '"');
		} else {
			trigger_error ('Bad package "' . $sIncPath . '"');
		}
	}
}


function getDirFiles ( $dir, $showHidden = false){
	$files =  array();
	if (!is_dir($dir)){
		trigger_error('Can not find : '.$dir);
		return false;
	}
	if ( $root = @opendir($dir) ){
		while ($file = readdir ($root)){
			if ( ($file == '.' || $file == '..') || ($showHidden == false && stripos($file, '.') === 0)){continue;}

			if (substr($dir, -1) != '/') $dir .= '/';

			if( is_dir ($dir . $file) ){
				$files = array_merge($files, getDirFiles($dir . $file));
			} else {
				/*if ( stristr($file, 'tpl') )*/ $files[] = $dir . $file;
			}
		}
	}
	return $files;
}