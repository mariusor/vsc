<?php
vsc\import ('domain/models');
class vscEmptyProcessor extends vscProcessorA {

	public function init () {}

	public function handleRequest (vscHttpRequestA $oHttpRequest) {
		$oModel = new vscEmptyModel();
		$oModel->setPageTitle('[ null ]');
		$oModel->setPageContent('[ NULL ]');
		return $oModel;
	}
}