<?php
namespace tests\lib\presentation\requests\HttpRequestA;
use vsc\presentation\requests\HttpRequestA;

/**
 * @covers \vsc\presentation\requests\HttpRequestA::__construct()
 */
class __construct extends \PHPUnit_Framework_TestCase
{
	public function testBasic__construct()
	{
		$o = new HttpRequestA_underTest__construct();
		$this->assertInstanceOf(HttpRequestA::class, $o);
	}
}

class HttpRequestA_underTest__construct extends HttpRequestA {}
