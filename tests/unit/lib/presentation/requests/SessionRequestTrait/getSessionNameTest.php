<?php
namespace tests\lib\presentation\requests\SessionRequestTrait;
use vsc\presentation\requests\HttpRequestA;
use vsc\presentation\requests\SessionRequestTrait;

/**
 * @covers \vsc\presentation\requests\SessionRequestTrait::getSessionName()
 */
class getSessionName extends \PHPUnit_Framework_TestCase
{
	public function testGetEmptySessionName()
	{
		$this->markTestSkipped('PHP7 fucked up sessions');
		$o = new SessionRequest_underTest_getSessionName();
		$this->assertEquals('', $o->getSessionName());
	}
}

class SessionRequest_underTest_getSessionName {
	use SessionRequestTrait;
}
