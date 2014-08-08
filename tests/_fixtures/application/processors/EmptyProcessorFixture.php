<?php
namespace _fixtures\application\processors;

// \vsc\import ('application');
// \vsc\import ('processors');
use vsc\application\processors\ProcessorA;
use vsc\presentation\requests\HttpRequestA;

class EmptyProcessorFixture extends ProcessorA {
	protected $aLocalVars = array ('test' => null);

	public function init () {}

	public function handleRequest (HttpRequestA $oHttpRequest) {}
}
