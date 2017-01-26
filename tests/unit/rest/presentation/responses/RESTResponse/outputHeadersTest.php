<?php
namespace tests\rest\presentation\responses\RESTResponse;
use vsc\rest\presentation\responses\RESTResponse;

/**
 * @covers \vsc\rest\presentation\responses\RESTResponse::outputHeaders()
 */
class outputHeaders extends \BaseUnitTest
{
	public function testUseless()
	{
		$o = new RESTResponse();
		$this->assertNull($o->outputHeaders());
	}
}
