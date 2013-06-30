<?php
class vscJsonRPCRequest extends vscModelA {
	public $id = null;
	public $method = '';
	public $params = array();

	public function __construct ($oRequest = null) {
		/* @var $oRequest vscRawHttpRequest */

		if (vscRawHttpRequest::isValid($oRequest)) {
			$oRequest = vsc::getEnv()->getHttpRequest();
		}

		$this->id		= $oRequest->getVar ('id');
		$this->method	= $oRequest->getVar ('method');
		$this->params	= $oRequest->getVar ('params');
	}
}