<?php
namespace tests\lib\presentation\requests\HttpRequestA;
use vsc\presentation\requests\HttpRequestA;

/**
 * @covers \vsc\presentation\requests\HttpRequestA::getSessionName()
 */
class getSessionName extends \PHPUnit_Framework_TestCase
{
	public function testGetEmptySessionName()
	{
		$o = new HttpRequestA_underTest_getSessionName();
		$this->assertEquals('', $o->getSessionName());
	}
}

class HttpRequestA_underTest_getSessionName extends HttpRequestA {}
