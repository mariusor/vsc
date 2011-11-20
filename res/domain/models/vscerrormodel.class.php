<?php
import ('domain/models');
import ('presentation/responses');
class vscErrorModel extends vscEmptyModel {
	private $exception;

	public function __construct(Exception $e) {
		$this->setException($e);
		parent::__construct();
	}

	public function getPageTitle () {
		return vscHttpResponseType::getStatus($this->getException()->getCode());
	}

	public function getPageContent () {
		return $this->getException()->getMessage();
	}

	public function setException (Exception $e) {
		$this->exception = $e;
	}

	public function getException () {
		return $this->exception;
	}
}