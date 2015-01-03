<?php
namespace lib\domain\models\ModelA;

use vsc\domain\models\ModelA;

class implementsIterableTest extends \PHPUnit_Framework_TestCase {
	/**
	 * @covers \vsc\domain\models\ModelA::current
	 * @covers \vsc\domain\models\ModelA::next
	 * @covers \vsc\domain\models\ModelA::rewind
	 * @covers \vsc\domain\models\ModelA::key
	 * @covers \vsc\domain\models\ModelA::valid
	 */
	public function testImplementsIterable()
	{
		$o = new ModelA_underTest_implementsIterable();

		$oMirror = new \ReflectionClass($o);

		foreach($o as $key => $value) {
			$this->assertTrue($oMirror->hasProperty($key));
			$this->assertEquals($value, $oMirror->getProperty($key)->getValue($o));
		}
	}

}

class ModelA_underTest_implementsIterable extends ModelA {
	public $test;
	public $ana = 'test';
	public $mere = 123;
	public $grr = 6.66;
}
