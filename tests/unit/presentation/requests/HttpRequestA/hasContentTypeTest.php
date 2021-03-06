<?php
namespace tests\presentation\requests\HttpRequestA;
use vsc\presentation\requests\HttpRequestA;

/**
 * @covers \vsc\presentation\requests\HttpRequestA::hasContentType()
 */
class hasContentType extends \BaseUnitTest
{
	public function testDoesNotHaveContentType ()
	{
		$o = new HttpRequestA_underTest_hasContentType();
		$this->assertFalse($o->hasContentType());
	}

	public function testHasContentType() {
		$_SERVER['CONTENT_TYPE'] = 'test/test';
		$o = new HttpRequestA_underTest_hasContentType();
		$this->assertTrue($o->hasContentType());
	}
}

class HttpRequestA_underTest_hasContentType extends HttpRequestA { }

