<?php
namespace tests\lib\domain\models\ModelA;
use vsc\domain\models\ModelA;

/**
 * @covers \vsc\domain\models\ModelA::__get()
 */
class __get extends \PHPUnit_Framework_TestCase
{
	/**
	 * @covers \vsc\domain\models\ModelA::__get
	 */
	public function test__get()
	{
		$o = new ModelA_underTest___get();

		$oMirror = new \ReflectionClass($o);
		$properties = $oMirror->getProperties(\ReflectionProperty::IS_PUBLIC);

		foreach($properties as $key => $property) {
			$name = $property->getName();
			$value = $property->getValue($o);
			$this->assertEquals($value, $o->__get($name));
			$this->assertEquals($value, $o[$name]);
		}
	}
}

class ModelA_underTest___get extends ModelA {
	public $test;
	public $ana = 'test';
	public $mere = 123;
	public $grr = 6.66;
}