<?php
namespace _fixtures\application\processors;

// \vsc\import ('application/processors');
use vsc\application\processors\vscProcessorA;
use vsc\presentation\requests\vscHttpRequestA;

class testFixtureProcessor extends vscProcessorA {
	public $return;
	protected $aLocalVars = array ('test' => null);
	
	public function init () {}

	public function handleRequest (vscHttpRequestA $oHttpRequest) {
		return $this->return;
	}
}
