<?php
namespace tests\lib\application\sitemaps\SiteMapA;
use vsc\application\sitemaps\SiteMapA;

/**
 * @covers \vsc\application\sitemaps\SiteMapA::addStaticMap()
 */
class addStaticMap extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$o = new SiteMapA_underTest_addStaticMap();

		$oStaticMap = $o->addStaticMap('.*\.css', VSC_FIXTURE_PATH . 'static/fixture.css');
		$this->assertTrue($oStaticMap->isStatic());
	}
}

class SiteMapA_underTest_addStaticMap extends SiteMapA {}
