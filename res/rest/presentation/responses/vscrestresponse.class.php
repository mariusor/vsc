<?php

class vscRESTResponse extends vscHttpResponseA {
	protected $sContentType = 'application/json';

	public function outputHeaders() {
		d (parent::getContentType());
	}
}
