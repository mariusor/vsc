<?php
namespace tests\lib\domain\models\ModelA;
use vsc\domain\models\ModelA;

/**
 * @covers \vsc\domain\models\ModelA::valid()
 */
class valid extends \PHPUnit_Framework_TestCase
{
	/**
	 * @covers \vsc\domain\models\ModelA::valid
	 */
	public function testValid()
	{
		$o = new ModelA_underTest_valid();

		$oMirror = new \ReflectionClass($o);
		$properties = $oMirror->getProperties(\ReflectionProperty::IS_PUBLIC);
		foreach ($properties as $key => $property) {
			$this->assertTrue ( $o->valid ( $property->getName () ) );
		}

		$rand = uniqid('tst:');
		$this->assertFalse($o->valid($rand));
	}
}

class ModelA_underTest_valid extends ModelA {
	public $test;
}

