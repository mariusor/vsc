<?php
namespace tests\lib\application\sitemaps\MappingA;
use vsc\application\sitemaps\MappingA;

/**
 * @covers \vsc\application\sitemaps\MappingA::getModuleName()
 */
class getModuleName extends \BaseUnitTest
{
	public function testSetModuleMap()
	{
		$o = new MappingA_underTest_getModuleName();
		$sName = $o->getModuleName();
		$this->assertEquals(basename(VSC_RES_PATH), $sName);
	}
}

class MappingA_underTest_getModuleName extends MappingA {
	public function __construct ($sPath = null, $sRegex = null) {
		if (is_null($sPath)) {
			$sPath = __FILE__;
		}
		if (is_null($sRegex)) {
			$sRegex = '.*';
		}
		parent::__construct($sPath, $sRegex);
	}
}
