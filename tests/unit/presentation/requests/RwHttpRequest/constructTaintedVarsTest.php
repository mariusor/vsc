<?php
namespace tests\presentation\requests\RwHttpRequest;
use vsc\presentation\requests\RwHttpRequest;

/**
 * @covers \vsc\presentation\requests\RwHttpRequest::constructTaintedVars()
 */
class constructTaintedVars extends \BaseUnitTest
{
	public function testBasicConstructTaintedVars()
	{
		$o = new RwHttpRequest_underTest_constructTaintedVars();
		$o->constructTaintedVars();

		$ExistingTaintedVars = array(
			'module'	=> 'test',
			'cucu'		=> 'mucu',
			'height'	=> 143
		);
		$this->assertEquals($ExistingTaintedVars, $o->getTaintedVars());
	}
}

class RwHttpRequest_underTest_constructTaintedVars extends RwHttpRequest {
	public function __construct () {}

	public function getUri ($bUrlDecode = false) {
		return 'http://example.com/module:test/cucu:mucu/height:143/index.html?show=me';
	}
}
