<?php
import ('domain/models');

class vscErrorProcessor extends vscProcessorA implements vscErrorProcessorI {
	private $model;

	public function getErrorCode () {
		return $this->getModel()->getException()->getCode();
	}

	public function __construct (Exception $e) {
		$this->setException ($e);
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