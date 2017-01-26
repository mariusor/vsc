<?php
namespace tests\presentation\requests\HttpRequestA;
use vsc\presentation\requests\HttpRequestA;

/**
 * @covers \vsc\presentation\requests\HttpRequestA::getVar()
 */
class getVar extends \BaseUnitTest
{
	public function testInvalidKey()
	{
		$o = new HttpRequestA_underTest_getVar();
		$this->assertNull($o->getVar(uniqid()));
	}
}

class HttpRequestA_underTest_getVar extends HttpRequestA {}
