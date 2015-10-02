<?php
namespace tests\lib\presentation\requests\HttpRequestA;
use vsc\presentation\requests\HttpRequestA;

/**
 * @covers \vsc\presentation\requests\HttpRequestA::getUri()
 */
class getUri extends \PHPUnit_Framework_TestCase
{
	public function testGetEmptyUrl()
	{
		$_SERVER['REQUEST_URI'] = '';

		$o = new HttpRequestA_underTest_getUri();
		$this->assertEquals('', $o->getUri());
	}
}

class HttpRequestA_underTest_getUri extends HttpRequestA {}
