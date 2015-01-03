<?php
namespace tests\lib\domain\models\ModelA;
use vsc\domain\models\ModelA;

/**
 * @covers \vsc\domain\models\ModelA::offsetSet()
 */
class offsetSet extends \PHPUnit_Framework_TestCase
{
	/**
	 * @covers \vsc\domain\models\ModelA::offsetSet
	 */
	public function testBasicOffsetSet()
	{
		$o = new ModelA_underTest_offsetSet();

		$sOffset = 'test';
		$sValue1 = 'asd';

		$o->offsetSet($sOffset, $sValue1);
		$this->assertEquals($sValue1, $o[$sOffset]);

		$sValue2 = 'asdfgh';

		$o[$sOffset] = $sValue2;
		$this->assertEquals($sValue2, $o[$sOffset]);
	}
}

class ModelA_underTest_offsetSet extends ModelA {
	public $test;
}
