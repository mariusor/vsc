<?php
namespace tests\lib\presentation\requests\HttpRequestA;
use vsc\presentation\requests\HttpRequestA;

/**
 * @covers \vsc\presentation\requests\HttpRequestA::getHttpAccept()
 */
class getHttpAccept extends \PHPUnit_Framework_TestCase
{
	public function testEmptyAtInitialization()
	{
		$_SERVER['HTTP_ACCEPT'] = '';
		$o = new HttpRequestA_underTest_getHttpAccept();
		$this->assertEquals([], $o->getHttpAccept());
	}
}

class HttpRequestA_underTest_getHttpAccept extends HttpRequestA {}
