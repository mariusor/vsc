<?php
namespace tests\lib\application\sitemaps\MappingA;
use mocks\application\sitemaps\MapFixture;

/**
 * @covers \vsc\application\sitemaps\MappingA::setIsStatic()
 */
class setIsStatic extends \BaseUnitTest
{
	public function testSetIsStatic()
	{
		$o = new MappingA_underTest_setIsStatic();
		$o->setIsStatic(true);
		$this->assertTrue($o->isStatic());
		$o->setIsStatic(false);
		$this->assertFalse($o->isStatic());
	}
}

class MappingA_underTest_setIsStatic extends MapFixture {
	public function __construct ($sPath = null, $sRegex = null) {
		if (is_null($sPath)) {
			$sPath = __FILE__;
		}
		if (is_null($sRegex)) {
			$sRegex = '.*';
		}
		parent::__construct($sPath, $sRegex);
	}
	protected function mergeResources($oMap) {}
}
