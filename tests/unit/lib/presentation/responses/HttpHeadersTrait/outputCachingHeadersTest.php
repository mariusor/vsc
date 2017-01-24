<?php
namespace tests\lib\presentation\responses\HttpHeadersTrait;
use vsc\presentation\responses\HttpResponseA;

/**
 * @covers \vsc\presentation\responses\HttpHeadersTrait::outputCachingHeaders()
 */
class outputCachingHeaders extends \BaseUnitTest
{
	public function testNullInCLI()
	{
		$o = new HttpResponseA_underTest_outputCachingHeaders();
		$this->assertFalse($o->outputCachingHeaders());
	}
}

class HttpResponseA_underTest_outputCachingHeaders extends HttpResponseA {
	public function outputCachingHeaders() {
		return parent::outputCachingHeaders();
	}
}
