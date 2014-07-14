<?php
import ('application/processors');

class testFixtureProcessor extends vscProcessorA {
	public $return;
	protected $aLocalVars = array ('test' => null);
	
	public function init () {}

	public function handleRequest (vscHttpRequestA $oHttpRequest) {
		return $this->return;
	}
}
