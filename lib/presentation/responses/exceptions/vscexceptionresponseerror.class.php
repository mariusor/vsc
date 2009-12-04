<?php
import ('coreexceptions');
class vscExceptionResponseError extends vscException {
	private $iHttpErrorCode;

	public function __construct ($sMessage = null, $iCode = 500) {
		$this->iHttpErrorCode = $iCode;

		parent::__construct ($sMessage, $iCode);
	}

	public function getErrorCode () {
		return $this->iHttpErrorCode;
	}
}