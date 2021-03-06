<?php
namespace tests\application\sitemaps\SiteMapA;
use vsc\application\sitemaps\ClassMap;
use vsc\application\sitemaps\SiteMapA;
use vsc\application\sitemaps\MappingA;

/**
 * @covers \vsc\application\sitemaps\SiteMapA::addMap()
 */
class addMap extends \BaseUnitTest
{
	public function testBasicAddMap()
	{
		$o = new SiteMapA_underTest_addMap();
		$oModuleMap = $o->addMap('.*', VSC_MOCK_PATH . 'application/processors/ProcessorFixture.php');

		$this->assertInstanceOf(MappingA::class, $oModuleMap);
		$this->assertInstanceOf(ClassMap::class, $oModuleMap);
	}
}

class SiteMapA_underTest_addMap extends SiteMapA {}
