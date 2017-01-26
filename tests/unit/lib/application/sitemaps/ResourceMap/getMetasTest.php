<?php
namespace tests\lib\application\sitemaps\MappingA;
use mocks\application\sitemaps\ModuleMapFixture;
use vsc\application\sitemaps\ResourceMapTrait;

/**
 * @covers \vsc\application\sitemaps\ResourceMapTrait::getMetas()
 */
class getMetas extends \BaseUnitTest
{
	public function testEmptyAtInitialization()
	{
		$o = new MappingA_underTest_getMetas();
		$this->assertEmpty($o->getMetas());
	}

	public function testGetSpecificMeta()
	{
		$sType = 'test';
		$sValue = uniqid('test:');

		$o = new MappingA_underTest_getMetas();
		$o->addMeta($sType, $sValue);

		$this->assertEquals($sValue, $o->getMetas($sType));
	}

	public function testGetAllMetaInfo()
	{
		$sType = 'test';
		$sValue = uniqid('test:');

		$aVerify = array ($sType => $sValue);
		$o = new MappingA_underTest_getMetas();
		$o->addMeta($sType, $sValue);

		$this->assertEquals($aVerify, $o->getMetas());
	}
}

class MappingA_underTest_getMetas extends ModuleMapFixture {
	use ResourceMapTrait;
}

