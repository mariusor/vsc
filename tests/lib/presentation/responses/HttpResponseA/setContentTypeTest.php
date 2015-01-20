<?php
namespace tests\lib\presentation\responses\HttpResponseA;
use vsc\presentation\responses\HttpResponseA;

/**
 * @covers \vsc\presentation\responses\HttpResponseA::setContentType()
 */
class setContentType extends \PHPUnit_Framework_TestCase
{
	public function testBasicSetContentType()
	{
		$o = new HttpResponseA_underTest_setContentType();
		$sTest = 'test';
		$o->setContentType($sTest);

		$this->assertEquals($sTest, $o->getContentType());
	}
}

class HttpResponseA_underTest_setContentType extends HttpResponseA {}