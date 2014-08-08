<?php
namespace _fixtures\application\controllers;

use vsc\application\controllers\FrontControllerA;
use _fixtures\presentation\views\NullView;

class GenericFrontController extends FrontControllerA {
	public function getDefaultView() {
		return new NullView();
	}
}
