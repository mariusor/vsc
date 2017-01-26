<?php
namespace tests\application\sitemaps\MappingA;
use mocks\application\sitemaps\MapFixture;

/**
 * @covers \vsc\application\sitemaps\MappingA::isStatic()
 */
class isStatic extends \BaseUnitTest
{
	public function testNotStatic()
	{
		$o = new MappingA_underTest_isStatic();
		$this->assertFalse($o->isStatic());
	}
}

class MappingA_underTest_isStatic extends MapFixture {
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
