<?php
namespace tests\lib\domain\models\ModelA;
use vsc\domain\models\ModelA;

/**
 * @covers \vsc\domain\models\ModelA::count()
 */
class count extends \PHPUnit_Framework_TestCase
{

	/**
	 * @covers \vsc\domain\models\ModelA::count
	 */
	public function testCount()
	{
		$o = new ModelA_underTest_count();

		$oMirror = new \ReflectionClass($o);
		$properties = $oMirror->getProperties(\ReflectionProperty::IS_PUBLIC);

		$this->assertEquals(count($properties), $o->count());
		$this->assertEquals(count($properties), count($o));
	}
}

class ModelA_underTest_count extends ModelA {
	public $test;
}
