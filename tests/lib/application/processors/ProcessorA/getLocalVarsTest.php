<?php
namespace tests\lib\application\processors\ProcessorA;
use fixtures\application\processors\ProcessorFixture;

/**
 * @covers the public method ProcessorA::getLocalVars()
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
