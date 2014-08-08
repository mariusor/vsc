<?php
/**
 * @package presentation
 * @subpackage processors
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.11.18
 */
namespace vsc\application\processors;

// \vsc\import ('domain/models');
use vsc\domain\models\EmptyModel;
use vsc\presentation\requests\HttpRequestA;

class EmptyProcessor extends ProcessorA {

	public function init () {}

	public function handleRequest (HttpRequestA $oHttpRequest) {
		$oModel = new EmptyModel();
		$oModel->setPageTitle('[ null ]');
		$oModel->setPageContent('[ NULL ]');
		return $oModel;
	}
}
