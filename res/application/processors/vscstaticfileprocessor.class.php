<?php
/**
 * @package vsc_application
 * @subpackage controllers
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2011.02.21
 */

import ('domain/models');
class vscStaticFileProcessor extends vscProcessorA {
	private $sFilePath;

	public function setFilePath ($sPath) {
		$this->sFilePath = $sPath;
	}

	public function init () {}

	public function handleRequest (vscHttpRequestA $oHttpRequest) {
		$oModel = new vscStaticFileModel();
		$oModel->setFilePath($this->sFilePath);

		return $oModel;
	}
}