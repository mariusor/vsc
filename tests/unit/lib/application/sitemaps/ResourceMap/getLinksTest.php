<?php
namespace tests\lib\application\sitemaps\MappingA;
use mocks\application\sitemaps\ModuleMapFixture;
use vsc\application\sitemaps\ResourceMapTrait;

/**
 * @covers \vsc\application\sitemaps\ResourceMapTrait::getLinks()
 */
class getLinks extends \BaseUnitTest
{
	public function testEmptyAtInitialization()
	{
		$o = new MappingA_underTest_getLinks();
		$this->assertEmpty ($o->getLinks());
	}

	public function testBasicAddLink()
	{
		$sType = 'application/png';
		$aData = array();

		$aVerify = array ($sType=>array($aData));
		$o = new MappingA_underTest_getLinks();
		$o->addLink($sType, array());

		$this->assertEquals ($aVerify, $o->getLinks($sType));
	}
}

class MappingA_underTest_getLinks extends ModuleMapFixture {
	use ResourceMapTrait;
}
