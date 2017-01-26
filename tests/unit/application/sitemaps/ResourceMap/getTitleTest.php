<?php
namespace tests\application\sitemaps\MappingA;
use mocks\application\sitemaps\ModuleMapFixture;
use vsc\application\sitemaps\ResourceMapTrait;

/**
 * @covers \vsc\application\sitemaps\ResourceMapTrait::getTitle()
 */
class getTitle extends \BaseUnitTest
{
	public function testEmptyAtInitialize ()
	{
		$o = new MappingA_underTest_getTitle();
		$this->assertNull($o->getTitle());
	}
}

class MappingA_underTest_getTitle extends ModuleMapFixture {
	use ResourceMapTrait;
}
