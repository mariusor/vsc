<?php
namespace tests\lib\domain\models\ModelA;
use vsc\domain\models\ModelA;

/**
 * @covers the public method ModelA::offsetExists()
 */
class offsetExists extends \PHPUnit_Framework_TestCase
{
	/**
	 * @covers \vsc\domain\models\ModelA::offsetExists
	 */
	public function testBasicOffsetExists()
	{
		$o = new ModelA_underTest_offsetExists();

		$sExistentOffset = 'test';
		$this->assertTrue($o->offsetExists($sExistentOffset));

		$sInexistentOffset = uniqid();
		$this->assertFalse($o->offsetExists($sInexistentOffset));
	}

}

class ModelA_underTest_offsetExists extends ModelA {
	public $test;
}
