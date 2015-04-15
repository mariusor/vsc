<?php
namespace tests\lib\domain\models\ModelA;
use vsc\domain\models\ModelA;

/**
 * @covers \vsc\domain\models\ModelA::getCurrent()
 */
class getCurrent extends \PHPUnit_Framework_TestCase
{
	/**
	 * @covers \vsc\domain\models\ModelA::getCurrent()
	 */
	public function testKeyAtInitializationUsingReflectionOnModelA()
	{
		$o = new ModelA_underTest_getCurrent();

		$oMirror = new \ReflectionClass($o);
		$oOffsetMirror = $oMirror->getProperty('_current');
		$oOffsetMirror->setAccessible(true);

		$this->assertEquals($oOffsetMirror->getValue($o), $o->getCurrent());
		$this->assertEquals($o->key(), $o->getCurrent());
	}

	/**
	 * @covers \vsc\domain\models\ModelA::getCurrent()
	 */
	public function testKeyAtInitializationUsingPublicPropertiesReflection()
	{
		$o = new ModelA_underTest_getCurrent();

		$oMirror = new \ReflectionClass($o);
		$aProperties = $oMirror->getProperties();

		// first property should be returned by ModelA::getCurrent()
		$sReflectionKey = array_shift($aProperties)->name;

		$this->assertEquals($sReflectionKey, $o->getCurrent());
		$this->assertEquals($o->key(), $o->getCurrent());
	}
}

class ModelA_underTest_getCurrent extends ModelA {
	public $test;
	public function getCurrent() {
		return parent::getCurrent();
	}
}
