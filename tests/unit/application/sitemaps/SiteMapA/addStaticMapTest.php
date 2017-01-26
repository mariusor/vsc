<?php
namespace tests\application\sitemaps\SiteMapA;
use vsc\application\sitemaps\SiteMapA;

/**
 * @covers \vsc\application\sitemaps\SiteMapA::addStaticMap()
 */
class addStaticMap extends \BaseUnitTest
{
	public function testBasicAddSiteMap ()
	{
		$o = new SiteMapA_underTest_addStaticMap();

		$oStaticMap = $o->addStaticMap('.*\.css', VSC_MOCK_PATH . 'static/fixture.css');
		$this->assertTrue($oStaticMap->isStatic());
	}
}

class SiteMapA_underTest_addStaticMap extends SiteMapA {}
