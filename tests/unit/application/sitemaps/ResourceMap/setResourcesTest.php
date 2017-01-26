<?php
namespace tests\application\sitemaps\MappingA;
use mocks\application\sitemaps\ModuleMapFixture;
use vsc\application\sitemaps\ResourceMapTrait;

/**
 * @covers \vsc\application\sitemaps\ResourceMapTrait::setResources()
 */
class setResources extends \BaseUnitTest
{
	public function testBasicSetResources ()
	{
		$o = new MappingA_underTest_setResources();

		$aTest = ['test' => uniqid('test:')];
		$o->setResources($aTest);
		$this->assertEquals($aTest, $o->getResources());
	}
}

class MappingA_underTest_setResources extends ModuleMapFixture {
	use ResourceMapTrait;
}
