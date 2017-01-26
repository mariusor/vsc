<?php
namespace tests\application\sitemaps\ModuleMap;
use vsc\application\sitemaps\ModuleMap;

/**
 * @covers \vsc\application\sitemaps\ModuleMap::getNamespace()
 */
class getNamespace extends \BaseUnitTest
{
	public function testEmptyAtInitialization()
	{
		$o = new ModuleMap('.*', __FILE__);
		$this->assertEmpty($o->getNamespace());
	}
}
