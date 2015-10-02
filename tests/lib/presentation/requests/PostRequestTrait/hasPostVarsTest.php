<?php
namespace tests\lib\presentation\requests\PostRequestTrait;
use fixtures\presentation\requests\PopulatedRequest;

/**
 * @covers \vsc\presentation\requests\PostRequestTrait::hasPostVars()
 */
class hasPostVars extends \PHPUnit_Framework_TestCase
{
	public function testHasPostVars() {
		$o = new PopulatedRequest();
		// POST vars
		$this->assertTrue($o->hasPostVars());
	}

	public function testHasPostVarsAfterUnset() {
		$o = new PopulatedRequest();

		$o->setPostVars(null);
		$this->assertFalse ($o->hasPostVars());

		$o->setPostVars(array('ana' => 'mere'));
		$this->assertTrue ($o->hasPostVars());
	}
}
