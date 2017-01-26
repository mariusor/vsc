<?php
namespace vsc;

class ExceptionError extends \ErrorException {
	private $aErrorTypes = array(
		1		=> 'E_ERROR',
		2		=> 'E_WARNING',
		4		=> 'E_PARSE',
		8		=> 'E_NOTICE',
		16		=> 'E_CORE_ERROR',
		32		=> 'E_CORE_WARNING',
		64		=> 'E_COMPILE_ERROR',
		128		=> 'E_COMPILE_WARNING',
		256		=> 'E_USER_ERROR',
		512		=> 'E_USER_WARNING',
		1024	=> 'E_USER_NOTICE',
		2048	=> 'E_STRICT',
		4096	=> 'E_RECOVERABLE_ERROR',
		8192	=> 'E_DEPRECATED',
		16384	=> 'E_USER_DEPRECATED',
		32767	=> 'E_ALL',
	);

	public function getSeverityString() {
		return $this->aErrorTypes[$this->getSeverity()];
	}

	public static function isValid($e) {
		return ($e instanceof static);
	}
}
