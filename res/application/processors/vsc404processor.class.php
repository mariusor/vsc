<?php
import ('domain/models');
class vsc404Processor extends vscProcessorA implements vscErrorProcessorI {

	public function init () {}

	public function getErrorCode () {
		return 404;
	}

	public function handleRequest (vscHttpRequestA $oHttpRequest) {
		$oModel = new vscEmptyModel();
		$oModel->sTitle = '404: Not Found';
		$oModel->sContent = '<h1 style="color:#600">Not Found</h1>';
		return $oModel;
	}
}