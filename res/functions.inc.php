<?php
namespace vsc;
use vsc\infrastructure\vsc;

/**
 * Function to turn the triggered errors into exceptions
 * @author troelskn at gmail dot com
 * @see http://php.net/manual/en/class.errorexception.php
 * @param $iSeverity
 * @param $sMessage
 * @param $sFilename
 * @param $iLineNo
 * @throws ExceptionError
 * @return void
 */
function exceptions_error_handler ($iSeverity, $sMessage, $sFilename, $iLineNo) {
	if (error_reporting() == 0) {
		return;
	}

	if (error_reporting() & $iSeverity) {
		// the __autoload seems not to be working here
		include_once(realpath(VSC_LIB_PATH . 'exceptions/vscexceptionerror.php'));
		throw new ExceptionError ($sMessage, 0, $iSeverity, $sFilename, $iLineNo);
	}
}

if (!function_exists('d') ) {
function d () {
	$aRgs = func_get_args();
	$iExit = 1;

	for ($i = 0; $i < ob_get_level(); $i++) {
		// cleaning the buffers
		ob_end_clean();
	}

	if (!vsc::isCli()) {
		// not running in console
		echo '<pre>';
	}

	foreach ($aRgs as $object) {
		// maybe I should just output the whole array $aRgs
		try {
			var_dump($object);
			if (vsc::isCli()) echo "\n\n";
		} catch (\Exception $e) {
			//
		}
	}
	debug_print_backtrace();

	if (!vsc::isCli()) {
		// not running in console
		echo '</pre>';
	}
	exit ();
}
}

/**
 * the __autoload automagic function for class instantiation,
 * @param string $className
 * @return bool
 */
function loadClass ($className) {
	if (class_exists ($className, false)) {
		return true;
	}
	if (stristr ($className, '\\')) {
		$aPaths = explode('\\', $className);
		$className = array_pop ($aPaths);

		// converting versioning namespaces vX_Y to vX.Y folders - for the API
		$sPath = preg_replace('/v(\d)_(\d)/', 'v$1.$2', implode(DIRECTORY_SEPARATOR, $aPaths)) . DIRECTORY_SEPARATOR;
	}

	$fileIncluded = false;

	$sFilePath	= $className . '.php';
	if (stristr ($className, 'exception')) {
		$sExceptionsFilePath = 'exceptions' . DIRECTORY_SEPARATOR . $sFilePath;
		$fileIncluded = include_once ($sExceptionsFilePath);
	}
	if (!$fileIncluded) {
		$sNamespaceFilePath = (!empty($sPath) ? $sPath : '') . $sFilePath;
		$fileIncluded = @include_once ($sNamespaceFilePath);
	}
	if (!$fileIncluded) {
		$fileIncluded = @include_once ($sFilePath);
	}
	if ( !$fileIncluded || ( !in_array ($className,get_declared_classes()) && !in_array($className,get_declared_interfaces() ) ) ) {
		include_once (VSC_LIB_PATH . 'exceptions'.DIRECTORY_SEPARATOR.'vscException.php');
		include_once (VSC_LIB_PATH . 'exceptions'.DIRECTORY_SEPARATOR.'vscExceptionPath.php');
		include_once (VSC_LIB_PATH . 'exceptions'.DIRECTORY_SEPARATOR.'vscExceptionAutoload.php');

		$sExport = var_export(getPaths(),true);
		//throw new ExceptionAutoload('Could not load class ['.$className.'] in path: <pre style="font-weight:normal">' . $sExport . '</pre>');
		return false;
	}
	return true;
}

function getPaths () {
	return explode (PATH_SEPARATOR, get_include_path());
}

function cleanBuffers ($iLevel = null) {
	$aErrors = array();
	$iLevel = ob_get_level();
	for ($i = 0; $i < min(1, $iLevel) ; $i++) {
		ob_end_clean();
	}

	$iLevel = ob_get_level();
	for ($i = 0; $i < $iLevel; $i++) {
		if ( ob_get_length() > 0 ) {
			$s = ob_get_clean();
			$aErrors[$i] = $s;
		} else {
			ob_end_clean();
		}
	}

	return $aErrors;
}

function addPath ($pkgPath, $sIncludePath = null) {
	// removing the trailing / if it exists

	if (substr($pkgPath,-1) == DIRECTORY_SEPARATOR) {
		$pkgPath = substr ($pkgPath,0, -strlen (DIRECTORY_SEPARATOR));
	}
	if (is_null($sIncludePath)) {
		$sIncludePath 	= get_include_path();
	}

	// checking to see if the path exists already in the included path
	if (strpos ($sIncludePath, $pkgPath . PATH_SEPARATOR) === false) {
		set_include_path (
			$sIncludePath. PATH_SEPARATOR .
			$pkgPath
		);
	}
	return true;
}

/**
 * Adds the package name to the include path
 * Also we are checking if an existing import exists, which would define some application specific import rules
 * @param string $sIncPath
 * @throws ExceptionPackageImport
 * @return bool
 */
function import ($sIncPath) {
	// fixing the paths to be fully compliant with the OS - indifferently how they are set
	$sIncPath	= str_replace(array('/','\\'), array(DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR),$sIncPath);
	$bStatus 	= false;
	$sPkgLower 	= strtolower ($sIncPath);
	$sIncludePath 	= get_include_path();

	$sIncPathIsFolder = realpath($sIncPath);
	if ( is_dir ($sIncPathIsFolder) ) {
		// takes care of relative paths
		$bStatus |= addPath ($sIncPathIsFolder, $sIncludePath);
	}

	$aPaths 		= explode(PATH_SEPARATOR, $sIncludePath);
	krsort ($aPaths);

	// this definitely needs improvement
	foreach ($aPaths as $sPath) {
		$pkgPath 	= realpath($sPath . DIRECTORY_SEPARATOR . $sPkgLower);
		if ( is_dir($pkgPath) ) {
			$bStatus |= addPath ($pkgPath);
		}
	}

	if (!$bStatus) {
		throw new ExceptionPackageImport ('Bad package [' . $sIncPath . ']');
	} else {
		return true;
	}
}

if (!function_exists('_e')) {
	function getErrorHeaderOutput ($e = null) {
		if (!vsc::isCli()) {
			header ('HTTP/1.1 500 Internal Server Error');
			$sRet = '<?xml version="1.0" encoding="utf-8"?>';
			$sRet .= '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"';
			$sRet .= '"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
			$sRet .= '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">';
			$sRet .= '<head>';
			$sRet .= '<style>ul {padding:0; font-size:0.8em} li {padding:0.2em;display:inline} address {position:fixed;bottom:0;}</style>';
			$sRet .= '<title>Internal Error' . (!($e instanceof \Exception) ? '' : ': '. substr($e->getMessage(), 0, 20) . '...') . '</title>';
			$sRet .= '</head>';
			$sRet .= '<body>';
			$sRet .= '<strong>Internal Error' . (!($e instanceof \Exception) ? '' : ': '. $e->getMessage()) . '</strong>';
			$sRet .= '<address>&copy; VSC</address>';
			$sRet .= '<ul><li><a href="#" onclick="p = document.getElementById(\'trace\'); if (p.style.display==\'block\') p.style.display=\'none\';else p.style.display=\'block\'; return false">toggle trace</a></li><li><a href="javascript: p = document.getElementById(\'trace\'); document.location.href =\'mailto:'.ROOT_MAIL.'?subject=Problems&amp;body=\' + p.innerHTML; return false">mail me</a></li></ul>';

			if ($e instanceof \Exception)
				$sRet .= '<p style="font-size:.8em">Triggered in <strong>' . $e->getFile() . '</strong> at line ' . $e->getLine() .'</p>';

			$sRet .= '<pre style="position:fixed;bottom:2em;display:none;font-size:.8em" id="trace">';
		}

		return $sRet;
	}

	function _e ($e) {
		$aErrors = cleanBuffers();
		$sRet = '';
		if (!vsc::isCli()) {
			header ('HTTP/1.1 500 Internal Server Error');
			echo getErrorHeaderOutput ($e);
		}

		if ( isDebug() ) {
			echo ($e instanceof \Exception) ? $e->getTraceAsString() : '';
		}

		if (count($aErrors) > 0) {
			if (!vsc::isCli()) { echo '<h2>'; }
			echo 'Previous Errors';
			if (!vsc::isCli()) { echo '</h2>'; }
			if (!vsc::isCli()) { echo '<p>'; }
			echo implode ($aErrors, vsc::isCli() ? "\n" : '<br/>');
			if (!vsc::isCli()) { echo '</p>'; }
		}

		if (!vsc::isCli()) {
			echo '</pre>';
			echo '</body>';
			echo '</html>';
		} else {
			if ($e instanceof \Exception) {
				$e->getMessage() . "\n";
				$sRet .= "\t". $e->getFile() . ' at line ' . $e->getLine() . "\n";
			}
		}
		exit (0);
	}
}

if (!function_exists('isDebug')) {
	function isDebug() {
		return true;
	}
}
