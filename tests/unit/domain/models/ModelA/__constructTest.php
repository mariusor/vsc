<?php
namespace lib\domain\models\ModelA;
use vsc\domain\models\ModelA;

/**
 * Class __constructTest
 * @package lib\domain\models\ModelA
 * @covers \vsc\domain\models\ModelA::__construct()
 */
class __constructTest extends \BaseUnitTest {

	public function testBasicInstantiation() {
		$o = new ModelA_underTest___construct();

		$mirror = new \ReflectionClass($o);
		$mirrorCurrent = $mirror->getProperty('_current');
		$mirrorCurrent->setAccessible(true);

		$this->assertEquals('test', $mirrorCurrent->getValue($o));
	}
}

class ModelA_underTest___construct extends ModelA {
	public $test;
	public $ana;
}
