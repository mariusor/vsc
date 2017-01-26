<?php
namespace tests\application\sitemaps\MappingA;
use mocks\application\sitemaps\ModuleMapFixture;
use vsc\application\sitemaps\ResourceMapTrait;

/**
 * @covers \vsc\application\sitemaps\ResourceMapTrait::addHeader()
 */
class addHeader extends \BaseUnitTest
{
	public function testBasicSetHeader()
	{
		$o = new MappingA_underTest_addHeader();
		$sHeader = 'test';
		$sValue = uniqid('test:');
		$o->addHeader($sHeader, $sValue);

		$this->assertArraySubset(array($sHeader => $sValue), $o->getHeaders());
	}
}

class MappingA_underTest_addHeader extends ModuleMapFixture {
	use ResourceMapTrait;
}
