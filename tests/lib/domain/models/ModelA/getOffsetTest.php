<?php
namespace tests\lib\domain\models\ModelA;
use vsc\domain\models\ModelA;

/**
 * @covers the public method ModelA::getOffset()
 */
class getOffset extends \PHPUnit_Framework_TestCase
{
	/**
	 * @covers \vsc\domain\models\ModelA::getOffset()
	 */
	public function testKeyAtInitializationUsingReflectionOnModelA()
	{
		$o = new ModelA_underTest_getOffset();

		$oMirror = new \ReflectionClass(ModelA::class);
		$oOffsetMirror = $oMirror->getProperty('sOffset');
		$oOffsetMirror->setAccessible(true);

		$this->assertEquals($oOffsetMirror->getValue($o), $o->getOffset());
		$this->assertEquals($o->key(), $o->getOffset());
	}

	/**
	 * @covers \vsc\domain\models\ModelA::getOffset()
	 */
	public function testKeyAtInitializationUsingPublicPropertiesReflection()
	{
		$o = new ModelA_underTest_getOffset();

		$oMirror = new \ReflectionClass($o);
		$aProperties = $oMirror->getProperties();

		// first property should be returned by ModelA::getOffset()
		$sReflectionKey = array_shift($aProperties)->name;

		$this->assertEquals($sReflectionKey, $o->getOffset());
		$this->assertEquals($o->key(), $o->getOffset());
	}
}

class ModelA_underTest_getOffset extends ModelA {
	public $test;
}
