<?php
namespace tests\lib\application\processors\ProcessorA;
use fixtures\application\processors\ProcessorFixture;

/**
 * @covers \vsc\application\processors\ProcessorA::setLocalVars()
 */
class setLocalVars extends \PHPUnit_Framework_TestCase
{
	public function testSetLocalVars ()
	{
		$o = new ProcessorFixture();
		$fixtureValue = $o->getLocalVars();
		$localValue = array('test2' => 'grrr');

		$o->setLocalVars($localValue, true);
		$this->assertEquals(array_merge($fixtureValue, $localValue), $o->getLocalVars());
	}
}
