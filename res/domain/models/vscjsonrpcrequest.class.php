<?php
class vscJsonRPCRequest extends vscModelA {
	public $id = null;
	public $method = '';
	public $params = array();

	public function __construct () {
		/* @var $oRequest vscRawHttpRequest */
		$oRequest = vsc::getEnv()->getHttpRequest();

		$this->id		= $oRequest->getVar ('id');
		$this->method	= $oRequest->getVar ('method');
		$this->params	= $oRequest->getVar ('params');
	}
}