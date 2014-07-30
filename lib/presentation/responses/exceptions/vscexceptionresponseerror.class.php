<?php
namespace vsc\presentation\responses;

class vscExceptionResponseError extends vscExceptionResponse {
	private $iHttpErrorCode;

	public function __construct ($sMessage = null, $iCode = 500) {
		$this->iHttpErrorCode = $iCode;

		parent::__construct ($sMessage, $iCode);
	}

	public function getErrorCode () {
		return $this->iHttpErrorCode;
	}
}