<?php
namespace tests\application\sitemaps\ModuleMapTrait;
use vsc\application\sitemaps\ModuleMapTrait;

/**
 * @covers \vsc\application\sitemaps\ModuleMapTrait::getModuleName()
 */
class getModuleName extends \BaseUnitTest
{
	public function testSetModuleMap()
	{
		$o = new ModuleMap_underTest_getModuleName();
		$sName = $o->getModuleName();
		$this->assertEquals(basename(VSC_SRC_PATH), $sName);
	}
}

class ModuleMap_underTest_getModuleName {
	use ModuleMapTrait;
}
