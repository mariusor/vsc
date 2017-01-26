<?php
namespace tests\presentation\responses\HttpHeadersTrait;
use vsc\presentation\responses\HttpResponseA;

/**
 * @covers \vsc\presentation\responses\HttpHeadersTrait::outputHeaders()
 */
class outputHeaders extends \BaseUnitTest
{
	public function testNullInCLI()
	{
		$o = new HttpResponseA_underTest_outputHeaders();
		$this->assertFalse($o->outputHeaders());
	}
}

class HttpResponseA_underTest_outputHeaders extends HttpResponseA {}
