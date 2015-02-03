<?php
namespace tests\lib\presentation\requests\HttpRequestA;
use vsc\presentation\requests\HttpRequestA;

/**
 * @covers \vsc\presentation\requests\HttpRequestA::getIfNoneMatch()
 */
class getIfNoneMatch extends \PHPUnit_Framework_TestCase
{
	public function testEmptyAtInitialization()
	{
		$o = new HttpRequestA_underTest_getIfNoneMatch();
		$this->assertEquals('', $o->getIfNoneMatch());
	}
}

class HttpRequestA_underTest_getIfNoneMatch extends HttpRequestA {}
