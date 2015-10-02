<?php
namespace fixtures\application\controllers;

use vsc\application\controllers\FrontControllerA;
use fixtures\presentation\views\NullView;

class FrontControllerFixture extends FrontControllerA {
	public function getDefaultView() {
		return new NullView();
	}
}
