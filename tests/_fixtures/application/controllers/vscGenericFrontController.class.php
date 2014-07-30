<?php
namespace _fixtures\application\controllers;
use _fixtures\presentation\views\vscNullView;
use vsc\application\controllers\vscFrontControllerA;

// \vsc\import ('res/application/controllers');

class vscGenericFrontController extends vscFrontControllerA {
	public function getDefaultView() {
		return new vscNullView();
	}
}