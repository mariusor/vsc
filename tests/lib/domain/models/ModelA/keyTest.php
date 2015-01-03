<?php
namespace tests\lib\domain\models\ModelA;
use vsc\domain\models\ModelA;

/**
 * @covers the public method ModelA::key()
 */
class key extends \PHPUnit_Framework_TestCase
{
	/**
	 * @covers \vsc\domain\models\ModelA::key()
	 */
	public function testKeyAtInitializationUsingReflectionOnModelA()
	{
		$o = new ModelA_underTest_key();

		$oMirror = new \ReflectionClass(ModelA::class);
		$oOffsetMirror = $oMirror->getProperty('sOffset');
		$oOffsetMirror->setAccessible(true);

		$this->assertEquals($oOffsetMirror->getValue($o), $o->key());
	}

	/**
	 * @covers \vsc\domain\models\ModelA::key()
	 */
	public function testKeyAtInitializationUsingPublicPropertiesReflection()
	{
		$o = new ModelA_underTest_key();

		$oMirror = new \ReflectionClass($o);
		$aProperties = $oMirror->getProperties();

		// first property should be returned by ModelA::key()
		$sReflectionKey = array_shift($aProperties)->name;

		$this->assertEquals($sReflectionKey, $o->key());
	}
}

class ModelA_underTest_key extends ModelA {
	public $test;
}
