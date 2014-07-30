<?php
namespace vsc\presentation\responses;

class vscExceptionResponseError extends vscExceptionResponse {
	/**
	 * @var int
	 */
	private $iHttpErrorCode;

	public function __construct ($sMessage = null, $iCode = 500) {
		$this->iHttpErrorCode = $iCode;

		parent::__construct ($sMessage, $iCode);
	}

	/**
	 * @return int
	 */
	public function getErrorCode () {
		return $this->iHttpErrorCode;
	}
}