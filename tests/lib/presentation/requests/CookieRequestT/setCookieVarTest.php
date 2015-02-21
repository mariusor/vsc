<?php
namespace tests\lib\presentation\requests\CookieRequestT;
use vsc\presentation\requests\HttpRequestA;

/**
 * Class setCookieVarTest
 * @package lib\presentation\requests\CookieRequestT
 * @covers \vsc\presentation\requests\CookieRequestT::setCookieVar()
 */
class setCookieVarTest extends \PHPUnit_Framework_TestCase {
	public function testBasicSetCookieVar() {
		$o = new HttpRequestA_underTest_setCookieVar();
		$key = 'test';
		$value = uniqid('test:');
		$this->assertFalse(@$o->setCookieVar($key, $value));
	}
}

class HttpRequestA_underTest_setCookieVar extends HttpRequestA {
}
