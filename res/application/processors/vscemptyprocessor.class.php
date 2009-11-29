<?php
import ('domain/models');
class vscEmptyProcessor extends vscProcessorA {

	public function init () {}

	public function handleRequest (vscHttpRequestA $oHttpRequest) {
		$oModel = new vscEmptyModel();
		$oModel->setTitle('[ null ]');
		$oModel->setContent('[ NULL ]');
		return $oModel;
	}
}