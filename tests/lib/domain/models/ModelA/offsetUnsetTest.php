<?php
namespace tests\lib\domain\models\ModelA;
use vsc\domain\models\ModelA;

/**
 * @covers the public method ModelA::offsetUnset()
 */
class offsetUnset extends \PHPUnit_Framework_TestCase
{

	/**
	 * @covers \vsc\domain\models\ModelA::offsetUnset
	 */
	public function testOffsetUnset()
	{
		$o = new ModelA_underTest_offsetUnset();

		$oMirror = new \ReflectionClass($o);
		$properties = $oMirror->getProperties();
		$first = array_shift($properties);
		$name = $first->getName();

		// exists
		$this->assertEquals($first->getValue($o), $o[$name]);

		$o->offsetUnset($name);

		// doesn't exist anymore
		$this->assertNull($o[$name]);
	}
}

class ModelA_underTest_offsetUnset extends ModelA {
	public $test = 'test';
}
