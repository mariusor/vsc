<?php
namespace tests\presentation\requests\GetRequestTrait;
use mocks\presentation\requests\PopulatedRequest;

/**
 * @covers \vsc\presentation\requests\GetRequestTrait::hasGetVars()
 */
class hasGetVars extends \BaseUnitTest
{
	public function testHasGetVars() {
		$o = new PopulatedRequest();
		// GET vars
		$this->assertTrue($o->hasGetVars());
	}

	public function testHasGetVarsAfterUnset() {
		$o = new PopulatedRequest();

		$o->setGetVars([]);
		$this->assertFalse ($o->hasGetVars());

		$o->setGetVars(['ana' => 'mere']);
		$this->assertTrue ($o->hasGetVars());
	}
}
