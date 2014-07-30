<?php
/**
 * @package vsc_presentation
 * @subpackage processors
 * @author marius orcsik <marius@habarnam.ro>
 * @date 11.05.17
 */
namespace vsc\application\processors;

vsc\import ('domain/models');

class vscErrorProcessor extends vscProcessorA implements vscErrorProcessorI {
	private $model;

	public function getErrorCode () {
		$e = $this->getModel()->getException();
		if ($e instanceof vscExceptionResponseError) {
			return $e->getCode();
		} else {
			return 500;
		}
	}

	public function __construct (Exception $e) {
		$this->setException ($e);

		$oErrorMap = new vscErrorMap();
		$oErrorMap->setTemplatePath(VSC_RES_PATH . 'templates');
		$oErrorMap->setTemplate('error.tpl.php');

		$this->setMap ($oErrorMap);
	}

	public function getModel () {
		return $this->model;
	}

	public function init () {}

	public function setException (Exception $e) {
		$this->model = new vscErrorModel($e);
	}

	public function handleRequest (vscHttpRequestA $oHttpRequest) {
		return $this->getModel();
	}
}