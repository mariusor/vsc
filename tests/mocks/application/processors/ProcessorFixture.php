<?php
namespace mocks\application\processors;

use vsc\application\processors\ProcessorA;
use vsc\presentation\requests\HttpRequestA;

class ProcessorFixture extends ProcessorA {
	public $return;
	protected $aLocalVars = array ('test' => null);

	public function init () {}

	public function handleRequest (HttpRequestA $oHttpRequest) {
		return $this->return;
	}
}
