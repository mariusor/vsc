<?php
namespace tests\presentation\requests\CookieRequestTrait;
use mocks\presentation\requests\PopulatedRequest;

/**
 * @covers \vsc\presentation\requests\CookieRequestTrait::hasCookieVar()
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class hasCookieVar extends \BaseUnitTest
{
	public function testHasCookieVar() {
		$o = new PopulatedRequest();
		// Cookie var
		$this->assertTrue($o->hasCookieVar('user')); // 'user' => 'asddsasdad234'
	}

}
