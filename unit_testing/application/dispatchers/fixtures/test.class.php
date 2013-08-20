<?php
import ('application/processors');

class test extends vscProcessorA {
	public $return;
	
	public function init () {}

	public function handleRequest (vscHttpRequestA $oHttpRequest) {
		return $this->return;
	}
}
