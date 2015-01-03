<?php
namespace tests\lib\domain\models\ModelA;
use vsc\domain\models\ModelA;

/**
 * @covers \vsc\domain\models\ModelA::rewind()
 */
class rewind extends \PHPUnit_Framework_TestCase
{
	/**
	 * @covers \vsc\domain\models\ModelA::rewind
	 */
	public function testRewind()
	{
		$o = new ModelA_underTest_rewind();

		$oMirror = new \ReflectionClass($o);
		$properties = $oMirror->getProperties();

		$fp = array_shift($properties);
		foreach ($o as $name => $value) {
			$this->assertNotEmpty($name);
		}
		$o->rewind();

		$this->assertEquals($fp->getName(), $o->getOffset());
	}

}

class ModelA_underTest_rewind extends ModelA {
	public $test;
}
