<?php
namespace tests\lib\presentation\responses\HttpResponseA;
use vsc\presentation\responses\HttpResponseA;

/**
 * @covers \vsc\presentation\responses\HttpResponseA::getETag()
 */
class getETag extends \BaseUnitTest
{
	public function testETag () {
		$state = new HttpResponseA_underTest_getETag();

		$this->assertNull($state->getETag());

		$testValue = hash('sha1', uniqid('test:'), 'asd');
		$state->setETag($testValue);
		$this->assertEquals($testValue, $state->getETag());
	}
}

class HttpResponseA_underTest_getETag extends HttpResponseA {}
