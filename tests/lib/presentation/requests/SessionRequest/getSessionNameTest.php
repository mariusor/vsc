<?php
namespace tests\lib\presentation\requests\SessionRequest;
use vsc\presentation\requests\HttpRequestA;
use vsc\presentation\requests\SessionRequest;

/**
 * @covers \vsc\presentation\requests\SessionRequest::getSessionName()
 */
class getSessionName extends \PHPUnit_Framework_TestCase
{
	public function testGetEmptySessionName()
	{
		$o = new SessionRequest_underTest_getSessionName();
		$this->assertEquals('', $o->getSessionName());
	}
}

class SessionRequest_underTest_getSessionName {
	use SessionRequest;
}
