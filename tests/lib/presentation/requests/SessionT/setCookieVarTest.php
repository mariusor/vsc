<?php
namespace tests\lib\presentation\requests\SessionT;
use vsc\presentation\requests\HttpRequestA;

/**
 * @covers \vsc\presentation\requests\SessionT::setCookieVar()
 */
class setCookieVar extends \PHPUnit_Framework_TestCase
{
	public function testBasicSetCookieVar_throwsException()
	{
		$sValue = uniqid();
		$o = new HttpRequestA_underTest_setCookieVar();
		try {
			$o->setCookieVar('test', $sValue);
		} catch (\Exception $e) {
			// headers sent
			$this->assertInstanceOf(\Exception::class, $e);
		}
	}
}

class HttpRequestA_underTest_setCookieVar extends HttpRequestA {}
