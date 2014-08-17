<?php
namespace _fixtures\application\processors;

use vsc\application\processors\ProcessorA;
use vsc\presentation\requests\HttpRequestA;

class testFixtureProcessor extends ProcessorA {
	public $return;
	protected $aLocalVars = array ('test' => null);

	public function init () {}

	public function handleRequest (HttpRequestA $oHttpRequest) {
		return $this->return;
	}
}
