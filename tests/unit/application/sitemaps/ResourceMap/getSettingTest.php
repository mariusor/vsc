<?php
namespace tests\application\sitemaps\MappingA;
use mocks\application\sitemaps\ModuleMapFixture;
use vsc\application\sitemaps\ResourceMapTrait;

/**
 * @covers \vsc\application\sitemaps\ResourceMapTrait::getSetting()
 */
class getSetting extends \BaseUnitTest
{
	public function testEmptyAtInitialize ()
	{
		$sVar = 'test';
		$o = new MappingA_underTest_getSetting();
		$this->assertEquals('', $o->getSetting($sVar));
	}
}

class MappingA_underTest_getSetting extends ModuleMapFixture {
	use ResourceMapTrait;
}
