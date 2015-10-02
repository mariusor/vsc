<?php
namespace lib\domain\models\ModelA;
use vsc\domain\models\ModelA;

/**
 * @covers \vsc\domain\models\ModelA::toArray()
 */
class toArrayTest extends \PHPUnit_Framework_TestCase {
	/**
	 * @covers \vsc\domain\models\ModelA::toArray
	 */
	public function testToArray()
	{
		$o = new ModelA_underTest_toArray();

		$oMirror = new \ReflectionClass($o);
		$properties = $oMirror->getProperties(\ReflectionProperty::IS_PUBLIC);

		$array = $o->toArray();

		$this->assertEquals(count($properties), count($array));
		foreach($properties as $key => $property) {
			$name = $property->getName();

			$this->assertArrayHasKey($name, $array);
			$this->assertEquals($oMirror->getProperty($name)->getValue($o), $array[$name]);
		}

		foreach($array as $name => $value) {
			$this->assertTrue($oMirror->hasProperty($name));
			$this->assertEquals($value, $oMirror->getProperty($name)->getValue($o));
		}

	}
}

class ModelA_underTest_toArray extends ModelA {
	public $test;
	public $ana = 'test';
	public $mere = 123;
	public $grr = 6.66;
}
