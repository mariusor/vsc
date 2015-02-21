<?php
namespace tests\lib\presentation\requests\SessionRequestT;
use vsc\presentation\requests\HttpRequestA;

/**
 * @covers \vsc\presentation\requests\SessionRequestT::getSessionName()
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
