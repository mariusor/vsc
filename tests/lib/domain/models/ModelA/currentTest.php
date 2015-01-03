<?php
namespace tests\lib\domain\models\ModelA;
use vsc\domain\models\ModelA;

/**
 * @covers the public method ModelA::current()
 */
class current extends \PHPUnit_Framework_TestCase
{
	/**
	 * @covers \vsc\domain\models\ModelA::current
	 */
	public function testCurrentAtInitialization()
	{
		$o = new ModelA_underTest_current();
		$this->assertEquals($o->test, $o->current());
		$this->assertNull($o->current());

		$oMirror = new \ReflectionClass(ModelA::class);
		$oOffsetMirror = $oMirror->getProperty('sOffset');
		$oOffsetMirror->setAccessible(true);

		$sOffset = 'test';
		$this->assertEquals($sOffset, $oOffsetMirror->getValue($o));
	}

	/**
	 * @covers \vsc\domain\models\ModelA::current
	 */
	public function testCurrentAtAttribution()
	{
		$o = new ModelA_underTest_current();
		$oMirror = new \ReflectionClass(ModelA::class);
		$oOffsetMirror = $oMirror->getProperty('sOffset');
		$oOffsetMirror->setAccessible(true);

		$sOffset = 'test';
		$sValue = 'test123';

		$o->$sOffset = $sValue;

		$this->assertEquals($sOffset, $oOffsetMirror->getValue($o));
		$this->assertEquals($sValue, $o->current());
	}

	/**
	 * @covers \vsc\domain\models\ModelA::current
	 */
	public function testCurrentAtAttributionUsingBracketOperator()
	{
		$o = new ModelA_underTest_current();
		$oMirror = new \ReflectionClass(ModelA::class);
		$oOffsetMirror = $oMirror->getProperty('sOffset');
		$oOffsetMirror->setAccessible(true);

		$sOffset = 'test';
		$sValue = 'test123';
		$o[$sOffset] = $sValue;

		$this->assertEquals($sOffset, $oOffsetMirror->getValue($o));
		$this->assertEquals($sValue, $o->current());
	}
}

class ModelA_underTest_current extends ModelA {
	public $test;
}
