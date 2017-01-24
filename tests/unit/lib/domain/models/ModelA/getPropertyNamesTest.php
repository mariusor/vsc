<?php
namespace lib\domain\models\ModelA;
use vsc\domain\models\ModelA;

/**
 * Class getPropertyNamesTest
 * @package lib\domain\models\ModelA
 * @covers \vsc\domain\models\ModelA::getPropertyNames()
 */
class getPropertyNamesTest extends \BaseUnitTest {

	public function testBasicGetPublicPropertyNames() {
		$o = new ModelA_underTest_getPropertyNames();

		$this->assertEquals([
			'mere',
			'grrrr'
		], $o->getPropertyNames());
	}
	public function testBasicGetAllPublicPropertyNames() {
		$o = new ModelA_underTest_getPropertyNames();

		$this->assertEquals([
			'test',
			'ana',
			'mere',
			'grrrr'
		], $o->getPropertyNames(true));
	}
}

class ModelA_underTest_getPropertyNames extends ModelA {
	protected $test;
	private $ana;
	public $mere;
	public $grrrr;

	/**
	 * @param bool $bAll
	 * @return array
	 */
	public function getPropertyNames ($bAll = false) {
		return parent::getPropertyNames($bAll);
	}
}
