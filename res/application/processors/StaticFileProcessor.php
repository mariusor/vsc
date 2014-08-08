<?php
/**
 * @package application
 * @subpackage controllers
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2011.02.21
 */
namespace vsc\application\processors;

// \vsc\import ('domain/models');
use vsc\domain\models\StaticFileModel;
use vsc\presentation\requests\HttpRequestA;

class StaticFileProcessor extends ProcessorA {
	private $sFilePath;

	public function setFilePath ($sPath) {
		$this->sFilePath = $sPath;
	}

	public function init () {}

	public function handleRequest (HttpRequestA $oHttpRequest) {
		$oModel = new StaticFileModel();
		$oModel->setFilePath($this->sFilePath);

		return $oModel;
	}
}
