<?php
namespace tests\lib\application\sitemaps\MappingA;
use vsc\application\sitemaps\MappingA;

/**
 * @covers \vsc\application\sitemaps\MappingA::getSetting()
 */
class getSetting extends \BaseUnitTest
{
	public function testEmptyAtInitialize ()
	{
		$sVar = 'test';
		$o = new MappingA_underTest_getSetting();
		$this->assertEquals('', $o->getSetting($sVar));
	}
}

class MappingA_underTest_getSetting extends MappingA {
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
