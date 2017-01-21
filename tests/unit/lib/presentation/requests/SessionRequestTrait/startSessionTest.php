<?php
namespace tests\lib\presentation\requests\SessionRequestTrait;
use vsc\presentation\requests\HttpRequestA;
use vsc\presentation\requests\SessionRequestTrait;

/**
 * @covers \vsc\presentation\requests\SessionRequestTrait::startSession()
 */
class startSession extends \PHPUnit_Framework_TestCase
{
	protected function tearDown() {
		@session_destroy();
	}

	public function testUseless()
	{
        $this->markTestSkipped('PHP7 fucked up sessions');
		$sSessionId = uniqid('test:');
		@SessionRequestTrait::startSession($sSessionId);
		$this->assertEquals($sSessionId, session_id());
	}
}
