<?php
namespace _fixtures\application\controllers;

use vsc\application\controllers\vscFrontControllerA;
use _fixtures\presentation\views\vscNullView;

class vscGenericFrontController extends vscFrontControllerA {
	public function getDefaultView() {
		return new vscNullView();
	}
}