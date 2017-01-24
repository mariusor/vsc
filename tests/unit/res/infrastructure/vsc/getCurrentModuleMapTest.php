<?php
namespace tests\res\infrastructure\vsc;
use vsc\infrastructure\vsc;
use vsc\application\sitemaps\ExceptionSitemap;

/**
 * @covers \vsc\infrastructure\vsc::getCurrentModuleMap()
 */
class getCurrentModuleMap extends \BaseUnitTest
{
	public function testGetCurrentModuleMapWithoutAMap()
	{
		$o = new vsc();
		try {
			$o->getCurrentModuleMap();
		} catch (\Exception $e) {
			$this->assertInstanceOf(ExceptionSitemap::class, $e);
		}
	}
}
