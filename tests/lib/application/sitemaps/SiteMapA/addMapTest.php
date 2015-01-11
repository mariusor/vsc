<?php
namespace tests\lib\application\sitemaps\SiteMapA;
use vsc\application\sitemaps\SiteMapA;
use vsc\application\sitemaps\MappingA;
use vsc\application\sitemaps\ProcessorMap;

/**
 * @covers \vsc\application\sitemaps\SiteMapA::addMap()
 */
class addMap extends \PHPUnit_Framework_TestCase
{
	public function testBasicAddMap()
	{
		$o = new SiteMapA_underTest_addMap();
		$oModuleMap = $o->addMap('.*', VSC_FIXTURE_PATH . 'application/processors/ProcessorFixture.php');

		$this->assertInstanceOf(MappingA::class, $oModuleMap);
		$this->assertInstanceOf(ProcessorMap::class, $oModuleMap);
	}
}

class SiteMapA_underTest_addMap extends SiteMapA {}
