<?php
/**
 * @package vsc_presentation
 * @subpackage processors
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.11.18
 */
namespace vsc\application\processors;

// \vsc\import ('domain/models');
use vsc\domain\models\vscEmptyModel;
use vsc\presentation\requests\vscHttpRequestA;

class vscEmptyProcessor extends vscProcessorA {

	public function init () {}

	public function handleRequest (vscHttpRequestA $oHttpRequest) {
		$oModel = new vscEmptyModel();
		$oModel->setPageTitle('[ null ]');
		$oModel->setPageContent('[ NULL ]');
		return $oModel;
	}
}