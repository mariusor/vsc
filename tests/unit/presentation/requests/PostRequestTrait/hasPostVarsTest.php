<?php
namespace tests\presentation\requests\PostRequestTrait;
use mocks\presentation\requests\PopulatedRequest;

/**
 * @covers \vsc\presentation\requests\PostRequestTrait::hasPostVars()
 */
class hasPostVars extends \BaseUnitTest
{
	public function testHasPostVars() {
		$o = new PopulatedRequest();
		// POST vars
		$this->assertTrue($o->hasPostVars());
	}

	public function testHasPostVarsAfterUnset() {
		$o = new PopulatedRequest();

		$o->setPostVars([]);
		$this->assertFalse ($o->hasPostVars());

		$o->setPostVars(['ana' => 'mere']);
		$this->assertTrue ($o->hasPostVars());
	}
}
