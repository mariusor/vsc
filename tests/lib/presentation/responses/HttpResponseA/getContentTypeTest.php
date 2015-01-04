<?php
namespace tests\lib\presentation\responses\HttpResponseA;
use vsc\presentation\requests\ContentTypes;
use vsc\presentation\responses\HttpResponseA;

/**
 * @covers \vsc\presentation\responses\HttpResponseA::getContentType()
 */
class getContentType extends \PHPUnit_Framework_TestCase
{
	/**
	 * @covers \vsc\presentation\responses\HttpResponseA::getContentType()
	 * @covers \vsc\presentation\responses\HttpResponseA::setContentType()
	 */
	public function testSetGetContentType ()
	{
		$state = new HttpResponseA_underTest_getContentType();

		$this->assertNull($state->getContentType());

		$testValue = ContentTypes::Application;
		$state->setContentType($testValue);
		$this->assertEquals($testValue, $state->getContentType());
	}

}

class HttpResponseA_underTest_getContentType extends HttpResponseA {}
