<?php
/**
 * @package vsc_application
 * @subpackage controllers
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2011.02.21
 */
namespace vsc\application\processors;

// \vsc\import ('domain/models');
use vsc\domain\models\vscStaticFileModel;
use vsc\presentation\requests\vscHttpRequestA;

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