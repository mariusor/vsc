<?php
namespace tests\application\sitemaps\MappingA;
use mocks\application\sitemaps\ModuleMapFixture;
use vsc\application\sitemaps\ResourceMapTrait;

/**
 * @covers \vsc\application\sitemaps\ResourceMapTrait::getResources()
 */
class getResources extends \BaseUnitTest
{
	public function testEmptyAtInitialize ()
	{
		$o = new MappingA_underTest_getResources();
		$this->assertEquals([], $o->getResources());
	}
}

class MappingA_underTest_getResources extends ModuleMapFixture {
	use ResourceMapTrait;
}
