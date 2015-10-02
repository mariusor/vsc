<?php
namespace tests\lib\presentation\requests\HttpAuthenticationA;
use vsc\presentation\requests\HttpAuthenticationA;

/**
 * @covers \vsc\presentation\requests\HttpAuthenticationA::getType()
 */
class getType extends \PHPUnit_Framework_TestCase
{
	public function testEmptyAtInitialization()
	{
		$o = new HttpAuthenticationA_underTest_getType();
		$this->assertEmpty($o->getType());
	}
}

class HttpAuthenticationA_underTest_getType extends HttpAuthenticationA {}