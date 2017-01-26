<?php
namespace tests\domain\models\ArrayAccessTrait;
use vsc\domain\models\ModelA;

/**
 * @covers \vsc\domain\models\ModelA::valid()
 */
class valid extends \BaseUnitTest
{
	/**
	 * @covers \vsc\domain\models\ModelA::valid
	 */
	public function testValid()
	{
		$o = new ModelA_underTest_valid();

		$oMirror = new \ReflectionClass($o);
		foreach ($o as $key => $property) {
			$this->assertTrue ( $o->valid ( ) );
		}

		$rand = uniqid('tst:');
		$o[$rand];
		$this->assertFalse($o->valid());
	}
}

class ModelA_underTest_valid extends ModelA {
	public $test;
}

