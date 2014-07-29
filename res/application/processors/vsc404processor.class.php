<?php
vsc\import ('domain/models');

class vsc404Processor extends vscErrorProcessor {
	public function __construct () {
		parent::__construct( new vscExceptionResponseError('Not found', 404));
	}

	public function handleRequest(vscHttpRequestA $oHttpRequest) {
		$o404 = new vscHttpResponse();
		$o404->setStatus(404);
		$this->getMap()->setResponse($o404);

		return parent::handleRequest($oHttpRequest);
	}
}