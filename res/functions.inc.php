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
		include_once(realpath(VSC_LIB_PATH . 'coreexceptions/vscexceptionerror.class.php'));
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
	debug_print_backtrace();

	if (!isCli()) {
		// not running in console
		echo '</pre>';
	}
	exit ();
}


/**
 * the __autoload automagic function for class instantiation,
 * @param string $className
 */
function __autoload ($className) {
	if (class_exists ($className, false))  {
		return true;
	}

	$classNameLow = strtolower($className);

	$sFilePath	= $classNameLow . '.class.php';
	if (stristr ($classNameLow, 'exception')) {
		$sFilePath = 'exceptions' . DIRECTORY_SEPARATOR . $sFilePath;
		$fileIncluded = @include ($sFilePath);
	}
	$fileIncluded = @include ($sFilePath);
	if (!$fileIncluded) {
		include_once(realpath(VSC_LIB_PATH . 'coreexceptions/vscexception.class.php'));
		include_once(realpath(VSC_LIB_PATH . 'coreexceptions/vscexceptionpath.class.php'));
		include_once(realpath(VSC_LIB_PATH . 'coreexceptions/vscexceptionautoload.class.php'));

		throw new vscExceptionAutoload('Could not load class ['.$className.'] in path: ' . get_include_path());
	} else {
		return true;
	}
}

function getPaths () {
	return explode (PATH_SEPARATOR, get_include_path());
}

function addPath ($pkgPath) {
	if (is_dir ($pkgPath)) {
		$sPath = substr($pkgPath,-1);
		if ($sPath == DIRECTORY_SEPARATOR) {
			$pkgPath = substr ($pkgPath,0, -1);
		}
		$sIncludePath 	= get_include_path();

		if (strpos ($sIncludePath, $pkgPath . PATH_SEPARATOR) === false) {
			set_include_path (
				$pkgPath . PATH_SEPARATOR .
				$sIncludePath
			);
		}
		return true;
	}

	return false;
}

/**
 * Adds the package name to the include path
 * Also we are checking if an existing import exists, which would define some application specific import rules
 * @param string $sIncPath
 * @return bool
 * @throws vscExceptionPackageImport
 */

function import ($sIncPath) {
	$bStatus 	= false;
	$sPkgLower 	= strtolower ($sIncPath);

	if (is_dir ($sIncPath)) {
		return addPath ($sIncPath);
	}

	$sIncludePath 	= get_include_path();
	$aPaths 		= explode(PATH_SEPARATOR, $sIncludePath);

	foreach ($aPaths as $sPath) {
		$pkgPath = $sPath . DIRECTORY_SEPARATOR . $sPkgLower;
		if (is_dir ($pkgPath)) {
			$bStatus |= addPath ($pkgPath);
		}
	}

	if (!$bStatus) {
		include_once(realpath(VSC_LIB_PATH . 'coreexceptions/vscexception.class.php'));
		include_once(realpath(VSC_LIB_PATH . 'coreexceptions/vscexceptionpath.class.php'));
		include_once(realpath(VSC_LIB_PATH . 'coreexceptions/vscexceptionpackageimport.class.php'));

		throw new vscExceptionPackageImport ('Bad package [' . $sIncPath . ']');
	} else {
		return true;
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