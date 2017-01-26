<?php
namespace tests\lib\application\sitemaps\MappingA;
use mocks\application\sitemaps\ModuleMapFixture;
use vsc\application\sitemaps\ResourceMapTrait;

/**
 * @covers \vsc\application\sitemaps\ResourceMapTrait::addMeta()
 */
class addMeta extends \BaseUnitTest
{
	public function testGetSpecificMeta()
	{
		$sType = 'test';
		$sValue = uniqid('test:');

		$o = new MappingA_underTest_addMeta();
		$o->addMeta($sType, $sValue);

		$this->assertEquals($sValue, $o->getMetas($sType));
	}

	public function testGetAllMetaInfo()
	{
		$sType = 'test';
		$sValue = uniqid('test:');

		$aVerify = array ($sType => $sValue);
		$o = new MappingA_underTest_addMeta();
		$o->addMeta($sType, $sValue);

		$this->assertEquals($aVerify, $o->getMetas());
	}
}

class MappingA_underTest_addMeta extends ModuleMapFixture {
	use ResourceMapTrait;
}

