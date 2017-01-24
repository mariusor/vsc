<?php
namespace tests\lib\application\sitemaps\MappingA;
use vsc\application\sitemaps\MappingA;

/**
 * @covers \vsc\application\sitemaps\MappingA::getPath()
 */
class getPath extends \BaseUnitTest
{
	public function testBasicGetPath()
	{
		$o = new MappingA_underTest_getPath();
		$this->assertEquals(__FILE__, $o->getPath());
	}
}

class MappingA_underTest_getPath extends MappingA {
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
