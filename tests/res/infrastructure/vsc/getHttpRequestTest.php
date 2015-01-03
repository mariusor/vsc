<?php
namespace tests\res\infrastructure\vsc;
use vsc\infrastructure\vsc;

/**
 * @covers \vsc\infrastructure\vsc::getHttpRequest()
 */
class getHttpRequest extends \PHPUnit_Framework_TestCase
{
	public function testGetHttpRequest () {
		$this->assertInstanceOf(\vsc\presentation\requests\HttpRequestA::class, vsc::getEnv()->getHttpRequest());
	}

}
