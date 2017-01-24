<?php
namespace tests\lib\application\sitemaps\MappingA;
use vsc\application\sitemaps\ClassMap;
use vsc\application\sitemaps\MappingA;

/**
 * @covers \vsc\application\sitemaps\MappingA::merge()
 */
class merge extends \BaseUnitTest
{
	public function testBasicMerge()
	{
		$o = new MappingA_underTest_merge (self::class);

		$oMap = new ClassMap(self::class, '.*');
		$o->merge ($oMap);

		$this->assertEmpty($o->getResources());
		$this->assertEquals($oMap->getPath(), $o->getPath());
		$this->assertEquals('', $o->getTemplate());
		$this->assertNull($o->getTemplatePath());
	}
}

class MappingA_underTest_merge extends MappingA {
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
