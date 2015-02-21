<?php
namespace tests\lib\presentation\requests\GetRequestT;
use fixtures\presentation\requests\PopulatedRequest;

/**
 * @covers \vsc\presentation\requests\GetRequestT::hasGetVars()
 */
class hasGetVars extends \PHPUnit_Framework_TestCase
{
	public function testHasGetVars() {
		$o = new PopulatedRequest();
		// GET vars
		$this->assertTrue($o->hasGetVars());
	}

	public function testHasGetVarsAfterUnset() {
		$o = new PopulatedRequest();

		$o->setGetVars(null);
		$this->assertFalse ($o->hasGetVars());

		$o->setGetVars(array('ana' => 'mere'));
		$this->assertTrue ($o->hasGetVars());
	}
}
