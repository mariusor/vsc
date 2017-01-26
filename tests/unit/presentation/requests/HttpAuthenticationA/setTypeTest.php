<?php
namespace tests\presentation\requests\HttpAuthenticationA;
use vsc\presentation\requests\HttpAuthenticationA;

/**
 * @covers \vsc\presentation\requests\HttpAuthenticationA::setType()
 */
class setType extends \BaseUnitTest
{
	public function testBasicSetType()
	{
		$sTest = 'IHAVENOIDEAWHATTHISDOES';
		$o = new HttpAuthenticationA_underTest_setType();
		$o->setType($sTest);
		$this->assertEquals($sTest, $o->getType());
	}
}

class HttpAuthenticationA_underTest_setType extends HttpAuthenticationA {}
