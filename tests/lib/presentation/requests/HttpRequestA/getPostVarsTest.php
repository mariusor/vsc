<?php
namespace tests\lib\presentation\requests\HttpRequestA;
use vsc\presentation\requests\HttpRequestA;

/**
 * @covers \vsc\presentation\requests\HttpRequestA::getPostVars()
 */
class getPostVars extends \PHPUnit_Framework_TestCase
{
	public function testGetEmptyPostVars()
	{
		$_POST = [];
		$o = new HttpRequestA_underTest_getPostVars();
		$this->assertEquals([], $o->getPostVars());
	}
}

class HttpRequestA_underTest_getPostVars extends HttpRequestA {}
