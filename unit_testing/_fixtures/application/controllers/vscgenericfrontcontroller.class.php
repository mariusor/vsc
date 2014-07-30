<?php
// \vsc\import ('res/application/controllers');
use vsc\application\controllers\vscFrontControllerA;

class vscGenericFrontController extends vscFrontControllerA {
	public function getDefaultView() {
		return new vscNullView();
	}
}