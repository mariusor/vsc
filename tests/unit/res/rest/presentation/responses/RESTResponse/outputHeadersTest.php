<?php
namespace tests\res\rest\presentation\responses\RESTResponse;
use vsc\rest\presentation\responses\RESTResponse;

/**
 * @covers \vsc\rest\presentation\responses\RESTResponse::outputHeaders()
 */
class outputHeaders extends \PHPUnit_Framework_TestCase
{
	public function testUseless()
	{
		$o = new RESTResponse();
		$this->assertNull($o->outputHeaders());
	}
}
