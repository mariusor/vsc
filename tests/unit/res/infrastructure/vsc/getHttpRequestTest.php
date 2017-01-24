<?php
namespace tests\res\infrastructure\vsc;
use vsc\infrastructure\vsc;
use vsc\presentation\requests\HttpRequestA;

/**
 * @covers \vsc\infrastructure\vsc::getHttpRequest()
 */
class getHttpRequest extends \BaseUnitTest
{
	public function testGetHttpRequest () {
		$this->assertInstanceOf(HttpRequestA::class, vsc::getEnv()->getHttpRequest());
	}

}
