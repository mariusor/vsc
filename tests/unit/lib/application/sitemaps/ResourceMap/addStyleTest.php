<?php
namespace tests\lib\application\sitemaps\MappingA;
use mocks\application\sitemaps\ModuleMapFixture;
use vsc\application\sitemaps\ResourceMapTrait;

/**
 * @covers \vsc\application\sitemaps\ResourceMapTrait::addStyle()
 */
class addStyle extends \BaseUnitTest
{
	public function testSetBasicStyle()
	{
		$sStyle = VSC_MOCK_PATH . 'static/fixture.css';
		$sMedia = 'screen';

		$o = new MappingA_underTest_addStyle();

		$o->addStyle($sStyle, $sMedia);
		$this->assertArraySubset([$sMedia => [$sStyle]], $o->getStyles($sMedia));
		$this->assertArraySubset([$sMedia => [$sStyle]], $o->getStyles());
	}
}

class MappingA_underTest_addStyle extends ModuleMapFixture {
	use ResourceMapTrait;
}
