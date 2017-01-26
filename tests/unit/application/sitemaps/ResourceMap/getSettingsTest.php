<?php
namespace tests\application\sitemaps\MappingA;
use mocks\application\sitemaps\ModuleMapFixture;
use vsc\application\sitemaps\ResourceMapTrait;

/**
 * @covers \vsc\application\sitemaps\ResourceMapTrait::getSettings()
 */
class getSettings extends \BaseUnitTest
{
	public function testEmptyAtInitialize ()
	{
		$o = new MappingA_underTest_getSettings();
		$this->assertEquals([], $o->getSettings());
	}
}

class MappingA_underTest_getSettings extends ModuleMapFixture {
	use ResourceMapTrait;
}
