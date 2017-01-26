<?php
namespace tests\lib\application\sitemaps\MappingA;
use mocks\application\sitemaps\ModuleMapFixture;
use vsc\application\sitemaps\ResourceMapTrait;

/**
 * @covers \vsc\application\sitemaps\ResourceMapTrait::getPath()
 */
class getPath extends \BaseUnitTest
{
	public function testBasicGetPath()
	{
		$o = new MappingA_underTest_getPath();
		$this->assertEquals(__FILE__, $o->getPath());
	}
}

class MappingA_underTest_getPath extends ModuleMapFixture {
	public function __construct () {
		$sPath = __FILE__;
		$sRegex = '.*';
		parent::__construct($sPath, $sRegex);
	}

	use ResourceMapTrait;
}
