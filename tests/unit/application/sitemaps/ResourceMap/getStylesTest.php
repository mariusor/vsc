<?php
namespace tests\application\sitemaps\MappingA;
use mocks\application\sitemaps\ModuleMapFixture;
use vsc\application\sitemaps\ResourceMapTrait;

/**
 * @covers \vsc\application\sitemaps\ResourceMapTrait::getStyles()
 */
class getStyles extends \BaseUnitTest
{
	public function testEmptyAtInitialize ()
	{
		$o = new MappingA_underTest_getStyles();
		$this->assertEquals([], $o->getStyles());
	}
}

class MappingA_underTest_getStyles extends ModuleMapFixture {
	use ResourceMapTrait;
}
