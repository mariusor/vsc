<?php
namespace tests\presentation\requests\GetRequestTrait;
use mocks\presentation\requests\PopulatedRequest;

/**
 * @covers \vsc\presentation\requests\GetRequestTrait::hasGetVar()
 */
class hasGetVar extends \BaseUnitTest
{
	public function testHasGetVar() {
		$o = new PopulatedRequest();
		// GET var
		$this->assertTrue($o->hasGetVar('cucu')); // 'cucu' => 'pasare','ana' => 'are', 'mere' => '', 'test' => 123
		$this->assertTrue($o->hasGetVar('ana'));
		$this->assertTrue($o->hasGetVar('test'));
	}
}
