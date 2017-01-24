<?php
namespace tests\lib\presentation\requests\SessionRequestTrait;
use vsc\presentation\requests\HttpRequestA;
use vsc\presentation\requests\SessionRequestTrait;

/**
 * @covers \vsc\presentation\requests\SessionRequestTrait::getSessionVars()
 */
class getSessionVars extends \BaseUnitTest
{
	public function testGetEmptySession()
	{
		$o = new SessionRequest_underTest_getSessionVars();
		$this->assertEquals([], $o->getSessionVars());
	}
}
class SessionRequest_underTest_getSessionVars {
	use SessionRequestTrait;
}
