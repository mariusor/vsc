<?php
namespace tests\application\sitemaps\MappingA;
use mocks\application\sitemaps\ModuleMapFixture;
use vsc\application\sitemaps\ResourceMapTrait;

/**
 * @covers \vsc\application\sitemaps\ResourceMapTrait::addSetting()
 */
class addSetting extends \BaseUnitTest
{
	public function testBasicAddSetting()
	{
		$sVar = 'test';
		$sVal = uniqid('test:');

		$o = new MappingA_underTest_addSetting();

		$o->addSetting($sVar, $sVal);
		$this->assertEquals($sVal, $o->getSetting($sVar));
	}
}

class MappingA_underTest_addSetting extends ModuleMapFixture {
	use ResourceMapTrait;
}
