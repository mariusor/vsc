<?php
namespace tests\presentation\requests\CookieRequestTrait;
use vsc\presentation\requests\CookieRequestTrait;
use vsc\presentation\requests\HttpRequestA;

/**
 * Class setCookieVarTest
 * @covers \vsc\presentation\requests\CookieRequestTrait::setCookieVar()
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class setCookieVarTest extends \BaseUnitTest {

	public function testBasicSetCookieVar() {
		$o = new CookieRequest_underTest_setCookieVar();
		$key = 'test';
		$value = uniqid('test:');
		$this->assertTrue($o->setCookieVar($key, $value));
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
	use CookieRequestTrait;
}
