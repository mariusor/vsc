<?php
namespace tests\application\sitemaps\ModuleMap;
use vsc\application\sitemaps\ModuleMap;

/**
 * @covers \vsc\application\sitemaps\ModuleMap::setMainTemplate()
 */
class setMainTemplate extends \BaseUnitTest
{
	public function testBasicSetMainTemplatePath()
	{
		$o = new ModuleMap('.*', __FILE__);
		$this->assertEmpty($o->getMainTemplate());

		$path = VSC_MOCK_PATH . 'templates/';
		$tpl = 'main.tpl.php';
		$o->setMainTemplatePath($path);
		$o->setMainTemplate($tpl);

		$this->assertEquals($tpl, $o->getMainTemplate());
	}
}
