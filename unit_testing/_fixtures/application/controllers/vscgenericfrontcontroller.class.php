<?php
vsc\import ('res/application/controllers');

class vscGenericFrontController extends vscFrontControllerA {
	public function getDefaultView() {
		return new vscNullView();
	}
}