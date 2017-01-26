<?php
namespace tests\application\sitemaps\ModuleMap;
use vsc\application\sitemaps\ModuleMap;

/**
 * @covers \vsc\application\sitemaps\ModuleMap::getMainTemplate()
 */
class getMainTemplate extends \BaseUnitTest
{
	public function testEmptyAtInitialization()
	{
		$o = new ModuleMap('.*', __FILE__);
		$this->assertEmpty($o->getMainTemplate());
	}
}
