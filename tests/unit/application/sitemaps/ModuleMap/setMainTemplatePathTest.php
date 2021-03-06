<?php
namespace tests\application\sitemaps\ModuleMap;
use vsc\application\sitemaps\ModuleMap;

/**
 * @covers \vsc\application\sitemaps\ModuleMap::setMainTemplatePath()
 */
class setMainTemplatePath extends \BaseUnitTest
{
	public function testBasicSetMainTemplatePath()
	{
		$o = new ModuleMap('.*', __FILE__);
		$this->assertEmpty($o->getMainTemplatePath());

		$path = VSC_MOCK_PATH . 'templates/';
		$o->setMainTemplatePath($path);

		$this->assertEquals($path, $o->getMainTemplatePath());
	}
}
