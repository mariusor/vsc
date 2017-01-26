<?php
namespace tests\lib\application\sitemaps\MappingA;
use mocks\application\sitemaps\ModuleMapFixture;
use vsc\application\sitemaps\ResourceMapTrait;

/**
 * @covers \vsc\application\sitemaps\ResourceMapTrait::setTitle()
 */
class setTitle extends \BaseUnitTest
{
	public function testBasicSetTitle ()
	{
		$o = new MappingA_underTest_setTitle();
		$sTest = uniqid('test:');
		$o->setTitle($sTest);
		$this->assertEquals($sTest, $o->getTitle());
	}
}

class MappingA_underTest_setTitle extends ModuleMapFixture {
	use ResourceMapTrait;
}
