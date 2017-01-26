<?php
namespace tests\application\sitemaps\MappingA;
use mocks\application\sitemaps\ModuleMapFixture;
use vsc\application\sitemaps\ResourceMapTrait;

/**
 * @covers \vsc\application\sitemaps\ResourceMapTrait::addScript()
 */
class addScript extends \BaseUnitTest
{
	public function testAddScriptWithFullPath()
	{
		$sPath = __FILE__;

		$o = new MappingA_underTest_addScript();
		$o->addScript($sPath);

		$this->assertArraySubset(array($sPath), $o->getScripts());
	}

	public function testAddScriptWithRelativePath()
	{
		$sPath = basename(__FILE__);

		$o = new MappingA_underTest_addScript();
		$o->addScript($sPath);

		$this->assertArraySubset(array($sPath), $o->getScripts());
	}
}

class MappingA_underTest_addScript extends ModuleMapFixture {
	use ResourceMapTrait;
}
