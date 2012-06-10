<?php
import ('domain/models');

class vsc404Processor extends vscErrorProcessor {
	private $model;

	public function getModel () {
		return $this->model;
	}

	public function __construct () {
		$e = new vscExceptionResponseError('Not found', 404);
		$this->model = new vscErrorModel($e);
	}
}