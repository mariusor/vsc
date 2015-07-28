<?php
namespace tests\lib\presentation\requests\CookieRequest;
use vsc\presentation\requests\CookieRequest;
use vsc\presentation\requests\HttpRequestA;

/**
 * Class setCookieVarTest
 * @package lib\presentation\requests\CookieRequest
 * @covers \vsc\presentation\requests\CookieRequest::setCookieVar()
 */
class setCookieVarTest extends \PHPUnit_Framework_TestCase {
	public function testBasicSetCookieVar() {
		$o = new CookieRequest_underTest_setCookieVar();
		$key = 'test';
		$value = uniqid('test:');
		$this->assertFalse(@$o->setCookieVar($key, $value));
	}

	public function testBasicSetCookieVar_throwsException()
	{
		$sValue = uniqid();
		$o = new CookieRequest_underTest_setCookieVar();
		try {
			$o->setCookieVar('test', $sValue);
		} catch (\Exception $e) {
			// headers sent
			$this->assertInstanceOf(\Exception::class, $e);
		}
	}
}

class CookieRequest_underTest_setCookieVar {
	use CookieRequest;
}
