<?php
namespace tests\lib\application\sitemaps\MappingA;
use mocks\application\sitemaps\MapFixture;

/**
 * @covers \vsc\application\sitemaps\MappingA::getRegex()
 */
class getRegex extends \BaseUnitTest
{
	public function testBasicGetRegex()
	{
		$o = new MappingA_underTest_getRegex();
		$this->assertEquals('.*', $o->getRegex());
	}
}

class MappingA_underTest_getRegex extends MapFixture {
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
