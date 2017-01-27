<?php
namespace tests\presentation\requests\SessionRequestTrait;
use vsc\presentation\requests\HttpRequestA;
use vsc\presentation\requests\SessionRequestTrait;

/**
 * @covers \vsc\presentation\requests\SessionRequestTrait::getSessionName()
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class getSessionName extends \BaseUnitTest
{
	public function testGetEmptySessionName()
	{
		$o = new SessionRequest_underTest_getSessionName();
		$this->assertEquals('', $o->getSessionName());
	}
}

class SessionRequest_underTest_getSessionName {
	use SessionRequestTrait;
}
