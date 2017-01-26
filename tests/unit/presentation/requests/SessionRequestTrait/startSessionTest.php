<?php
namespace tests\presentation\requests\SessionRequestTrait;
use vsc\presentation\requests\HttpRequestA;
use vsc\presentation\requests\SessionRequestTrait;

/**
 * @covers \vsc\presentation\requests\SessionRequestTrait::startSession()
 */
class startSession extends \BaseUnitTest
{
	protected function tearDown() {
		@session_destroy();
	}

	public function testUseless()
	{
		$sSessionId = uniqid('test:');
		@SessionRequestTrait::startSession($sSessionId);
		$this->assertEquals($sSessionId, session_id());
	}
}
