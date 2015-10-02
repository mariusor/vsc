<?php
namespace res\infrastructure\vsc;

use vsc\application\sitemaps\ExceptionSitemap;
use vsc\application\sitemaps\RwSiteMap;
use vsc\application\sitemaps\SiteMapA;
use vsc\infrastructure\vsc;

class getSiteMapTest extends \PHPUnit_Framework_TestCase
{
	public function testExceptionIfNoSiteMapLoaded() {
		try {
			vsc::getEnv()->getSiteMap();
		} catch (\Exception $e) {
			$this->assertInstanceOf(ExceptionSitemap::class, $e);
			$this->assertStringEndsWith('No sitemap loaded.', $e->getMessage());
		}
	}

	public function testGetBasicSiteMap() {
		vsc::getEnv()->getDispatcher()->loadSiteMap(VSC_MOCK_PATH . 'config/map.php');
		$o = vsc::getEnv()->getSiteMap();
		$this->assertInstanceOf(SiteMapA::class, $o);
		$this->assertInstanceOf(RwSiteMap::class, $o);
	}
}
