<?php
namespace tests\lib\domain\models\ModelA;
use vsc\domain\models\ModelA;

/**
 * @covers the public method ModelA::offsetGet()
 */
class offsetGet extends \PHPUnit_Framework_TestCase
{
	/**
	 * @covers \vsc\domain\models\ModelA::offsetGet
	 */
	public function testBasicOffsetGet()
	{
		$o = new ModelA_underTest_offsetGet();

		$sOffset = 'test';

		$this->assertEquals('asd', $o[$sOffset]);
		$this->assertEquals('asd', $o->offsetGet($sOffset));
	}
}

class ModelA_underTest_offsetGet extends ModelA {
	public $test = 'asd';
}
