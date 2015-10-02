<?php
namespace mocks\application\controllers;

use vsc\application\controllers\FrontControllerA;
use mocks\presentation\views\NullView;

class FrontControllerFixture extends FrontControllerA {
	public function getDefaultView() {
		return new NullView();
	}
}
