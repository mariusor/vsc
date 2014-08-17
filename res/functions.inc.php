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
		throw new ExceptionError ($sMessage, 0, $iSeverity, $sFilename, $iLineNo);
	}
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

function getErrorHeaderOutput ($e = null) {
	$sRet = '';
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
		$sRet .= '<ul>';
		$sRet .= '<li><a href="#" onclick="p = document.getElementById(\'trace\'); if (p.style.display==\'block\') p.style.display=\'none\';else p.style.display=\'block\'; return false">toggle trace</a></li>';
		if (defined ('ROOT_MAIL')) {
			$sRet .= '<li><a href="javascript: p = document.getElementById(\'trace\'); document.location.href =\'mailto:'.ROOT_MAIL.'?subject=Problems&amp;body=\' + p.innerHTML; return false">mail me</a></li>';
		}
		$sRet .= '</ul>';

		if ($e instanceof \Exception)
			$sRet .= '<p style="font-size:.8em">Triggered in <strong>' . $e->getFile() . '</strong> at line ' . $e->getLine() .'</p>';

		$sRet .= '<pre style="position:fixed;bottom:2em;display:'.(vsc::getEnv()->isDevelopment() ? 'block' : 'none').';font-size:.8em" id="trace">';
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

if (!function_exists('isDebug')) {
	function isDebug() {
		return true;
	}
}
