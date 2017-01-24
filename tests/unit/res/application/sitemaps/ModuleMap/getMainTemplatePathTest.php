<?php
namespace tests\res\application\sitemaps\ModuleMap;
use vsc\application\sitemaps\ModuleMap;

/**
 * @covers \vsc\application\sitemaps\ModuleMap::getMainTemplatePath()
 */
class getMainTemplatePath extends \BaseUnitTest
{
	public function testEmptyAtInitialization()
	{
		$o = new ModuleMap('.*', __FILE__);
		$this->assertEmpty($o->getMainTemplatePath());
	}
}
