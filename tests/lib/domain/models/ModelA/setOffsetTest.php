<?php
namespace tests\lib\domain\models\ModelA;
use vsc\domain\models\ModelA;

/**
 * @covers \vsc\domain\models\ModelA::setOffset()
 */
class setOffset extends \PHPUnit_Framework_TestCase
{

	/**
	 * @covers \vsc\domain\models\ModelA::__set
	 */
	public function test__set()
	{
		$o = new ModelA_underTest___set();

		$oMirror = new \ReflectionClass($o);
		$properties = $oMirror->getProperties(\ReflectionProperty::IS_PUBLIC);

		foreach($properties as $key => $property) {
			$name = $property->getName();
			$value = uniqid($property . ':__set:');
			$o->__set($name, $value);
			$this->assertEquals($value, $o->__get($name));
			$this->assertEquals($value, $o[$name]);
		}

		foreach($properties as $key => $property) {
			$name = $property->getName();
			$value = uniqid($property . ':[]:');
			$o[$name] = $value;
			$this->assertEquals($value, $o->__get($name));
			$this->assertEquals($value, $o[$name]);
		}
	}
}

class ModelA_underTest___set extends ModelA {
	public $test;
	public $ana = 'test';
	public $mere = 123;
	public $grr = 6.66;
}
