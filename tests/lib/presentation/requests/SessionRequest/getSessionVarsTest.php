<?php
namespace tests\lib\presentation\requests\SessionRequest;
use vsc\presentation\requests\HttpRequestA;
use vsc\presentation\requests\SessionRequest;

/**
 * @covers \vsc\presentation\requests\SessionRequest::getSessionVars()
 */
class getSessionVars extends \PHPUnit_Framework_TestCase
{
	public function testGetEmptySession()
	{
		$o = new SessionRequest_underTest_getSessionVars();
		$this->assertEquals([], $o->getSessionVars());
	}
}
class SessionRequest_underTest_getSessionVars {
	use SessionRequest;
}
