<?php
namespace tests\application\sitemaps\MappingA;
use mocks\application\sitemaps\MapFixture;

/**
 * @covers \vsc\application\sitemaps\MappingA::getValidAuthenticationSchemas()
 */
class getValidAuthenticationSchemas extends \BaseUnitTest
{
	public function testEmptyAtInitialize ()
	{
		$o = new MappingA_underTest_getValidAuthenticationSchemas();
		$this->assertEquals([], $o->getValidAuthenticationSchemas());
	}
}

class MappingA_underTest_getValidAuthenticationSchemas extends MapFixture {
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
