<?php
class vsc404Processor extends vscProcessorA implements vscErrorProcessorI {

	public function init () {}

	public function getErrorCode () {
		return 404;
	}

	public function handleRequest (vscHttpRequestA $oHttpRequest) {
		return '<html><head><title>404: Not Found</title></head><body><h1>Not Found</h1></body></html>';
	}
}