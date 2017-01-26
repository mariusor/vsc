<?php
namespace tests\application\sitemaps\MappingA;
use mocks\application\sitemaps\ModuleMapFixture;
use vsc\application\sitemaps\ResourceMapTrait;

/**
 * @covers \vsc\application\sitemaps\ResourceMapTrait::addLink()
 */
class addLink extends \BaseUnitTest
{
	public function testBasicAddLink()
	{
		$sType = 'application/png';
		$aData = array();

		$aVerify = array ($sType=>array($aData));
		$o = new MappingA_underTest_addLink();
		$o->addLink($sType, array());

		$this->assertEquals ($aVerify, $o->getLinks($sType));
	}
}

class MappingA_underTest_addLink extends ModuleMapFixture {
	use ResourceMapTrait;
}
