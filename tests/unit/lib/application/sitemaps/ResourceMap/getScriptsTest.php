<?php
namespace tests\lib\application\sitemaps\MappingA;
use mocks\application\sitemaps\ModuleMapFixture;
use vsc\application\sitemaps\ResourceMapTrait;

/**
 * @covers \vsc\application\sitemaps\ResourceMapTrait::getScripts()
 */
class getScripts extends \BaseUnitTest
{
	public function testEmptyAtInitialize ()
	{
		$o = new MappingA_underTest_getScripts();
		$this->assertEquals([], $o->getScripts());
	}
}

class MappingA_underTest_getScripts extends ModuleMapFixture {
	use ResourceMapTrait;
}
