<?php
namespace tests\lib\application\sitemaps\MappingA;
use mocks\application\sitemaps\MapFixture;

/**
 * @covers \vsc\application\sitemaps\MappingA::getTemplate()
 */
class getTemplate extends \BaseUnitTest
{
	public function testDefaultValue ()
	{
		$o = new MappingA_underTest_getTemplate();
		$this->assertNull($o->getTemplatePath());
	}
}

class MappingA_underTest_getTemplate extends MapFixture {
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
