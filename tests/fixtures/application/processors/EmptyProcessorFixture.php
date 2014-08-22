<?php
namespace fixtures\application\processors;

use vsc\application\processors\ProcessorA;
use vsc\presentation\requests\HttpRequestA;

class EmptyProcessorFixture extends ProcessorA {
	protected $aLocalVars = array ('test' => null);

	public function init () {}

	public function handleRequest (HttpRequestA $oHttpRequest) {}
}
