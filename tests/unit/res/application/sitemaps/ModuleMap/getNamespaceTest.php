<?php
namespace tests\res\application\sitemaps\ModuleMap;
use vsc\application\sitemaps\ModuleMap;

/**
 * @covers \vsc\application\sitemaps\ModuleMap::getNamespace()
 */
class getNamespace extends \PHPUnit_Framework_TestCase
{
	public function testEmptyAtInitialization()
	{
		$o = new ModuleMap('.*', __FILE__);
		$this->assertEmpty($o->getNamespace());
	}
}
