<?php
namespace tests\lib\presentation\requests\HttpRequestA;
use vsc\presentation\requests\HttpRequestA;

/**
 * @covers \vsc\presentation\requests\HttpRequestA::getHttpReferer()
 */
class getHttpReferer extends \PHPUnit_Framework_TestCase
{
	public function testEmptyAtInitialization()
	{
		$o = new HttpRequestA_underTest_getHttpReferer();
		$this->assertEquals('', $o->getHttpReferer());
	}
}

class HttpRequestA_underTest_getHttpReferer extends HttpRequestA {}
