<?php
namespace tests\lib\application\sitemaps\SiteMapA;
use vsc\application\sitemaps\SiteMapA;
use vsc\application\sitemaps\MappingA;
use mocks\application\processors\ProcessorFixture;
use vsc\application\sitemaps\ClassMap;

/**
 * @covers \vsc\application\sitemaps\SiteMapA::addClassMap()
 */
class addClassMap extends \PHPUnit_Framework_TestCase
{
	public function testBasicAddClassMap()
	{
		$o = new SiteMapA_underTest_addClassMap();
		$oMap = $o->addClassMap('.*', ProcessorFixture::class);

		$this->assertInstanceOf(MappingA::class, $oMap);
		$this->assertInstanceOf(ClassMap::class, $oMap);
	}
}

class SiteMapA_underTest_addClassMap extends SiteMapA {
	public function addClassMap($sRegex, $sClassName)
	{
		return parent::addClassMap($sRegex, $sClassName);
	}
}
