<?php
namespace tests\lib\application\processors\ProcessorA;
use mocks\application\processors\ProcessorFixture;

/**
 * @covers \vsc\application\processors\ProcessorA::getLocalVars()
 */
class getLocalVars extends \PHPUnit_Framework_TestCase
{

	public function testGetLocalVars ()
	{
		$o = new ProcessorFixture();
		$fixtureValue = array ('test' => null);
		$this->assertEquals($fixtureValue, $o->getLocalVars());
	}

}
