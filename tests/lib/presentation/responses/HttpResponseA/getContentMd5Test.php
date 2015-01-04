<?php
namespace tests\lib\presentation\responses\HttpResponseA;
use vsc\presentation\responses\HttpResponseA;

/**
 * @covers \vsc\presentation\responses\HttpResponseA::getContentMd5()
 */
class getContentMd5 extends \PHPUnit_Framework_TestCase
{
	/**
	 * @covers \vsc\presentation\responses\HttpResponseA::getContentMd5()
	 * @covers \vsc\presentation\responses\HttpResponseA::setContentMd5()
	 */
	public function testSetGetContentMd5 ()
	{
		$state = new HttpResponseA_underTest_getContentMd5();

		$this->assertNull($state->getContentMd5());

		$testValue = uniqid('test');
		$state->setContentMd5(md5($testValue));
		$this->assertEquals(md5($testValue), $state->getContentMd5());
	}
}

class HttpResponseA_underTest_getContentMd5 extends HttpResponseA {}
