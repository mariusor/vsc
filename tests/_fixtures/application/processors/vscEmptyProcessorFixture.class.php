<?php
namespace _fixtures\application\processors;

// \vsc\import ('application');
// \vsc\import ('processors');
use vsc\application\processors\vscProcessorA;
use vsc\presentation\requests\vscHttpRequestA;

class vscEmptyProcessorFixture extends vscProcessorA {
	protected $aLocalVars = array ('test' => null);

	public function init () {}

	public function handleRequest (vscHttpRequestA $oHttpRequest) {}
}
