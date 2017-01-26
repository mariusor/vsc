<?php
namespace tests\application\processors\ProcessorA;
use mocks\application\processors\ProcessorFixture;

/**
 * @covers \vsc\application\processors\ProcessorA::setLocalVars()
 */
class setLocalVars extends \BaseUnitTest
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
