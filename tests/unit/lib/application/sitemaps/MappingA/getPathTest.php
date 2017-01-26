<?php
namespace tests\lib\application\sitemaps\MappingA;
use mocks\application\sitemaps\ModuleMapFixture;
use vsc\application\sitemaps\ResourceMapTrait;

/**
 * @covers \vsc\application\sitemaps\MappingA::getPath()
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
	use ResourceMapTrait;

	public function __construct () {
		parent::__construct( __FILE__, '.*');
	}
}
