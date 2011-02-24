<?php
import ('domain/models');
class vscFileContentProcessor extends vscProcessorA {
	private $sFilePath;

	public function setFilePath ($sPath) {
		$this->sFilePath = $sPath;
	}

	public function init () {}

	public function handleRequest (vscHttpRequestA $oHttpRequest) {
		$oModel = new vscEmptyModel();
		$oModel->setPageContent(file_get_contents($this->sFilePath));
		return $oModel;
	}
}