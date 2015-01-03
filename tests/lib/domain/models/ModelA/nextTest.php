<?php
namespace tests\lib\domain\models\ModelA;
use vsc\domain\models\ModelA;

/**
 * @covers \vsc\domain\models\ModelA::next()
 */
class next extends \PHPUnit_Framework_TestCase
{
	/**
	 * @covers \vsc\domain\models\ModelA::next
	 */
	public function testNext()
	{
		$o = new ModelA_underTest_next();

		$oMirror = new \ReflectionClass($o);
		$aMirrorProperties = $oMirror->getProperties();

		foreach ($aMirrorProperties as $oMirrorProperty) {
			$this->assertNotEmpty($oMirrorProperty->getName());
			$this->assertEquals($oMirrorProperty->getName(), $o->getOffset());
		}
	}
}

class ModelA_underTest_next extends ModelA {
	public $test;
}

