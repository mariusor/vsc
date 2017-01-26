<?php
namespace tests\lib\application\sitemaps\MappingA;
use mocks\application\sitemaps\ModuleMapFixture;
use vsc\application\sitemaps\ResourceMapTrait;

/**
 * @covers \vsc\application\sitemaps\ResourceMapTrait::getHeaders()
 */
class getHeaders extends \BaseUnitTest
{
	public function testEmptyAtInitialization()
	{
		$o = new MappingA_underTest_getHeaders();
		$this->assertEmpty($o->getHeaders());
	}

	public function testBasicSetHeader()
	{
		$o = new MappingA_underTest_getHeaders();
		$sHeader = 'test';
		$sValue = uniqid('test:');
		$o->addHeader($sHeader, $sValue);

		$this->assertArraySubset(array($sHeader => $sValue), $o->getHeaders());
	}
}

class MappingA_underTest_getHeaders extends ModuleMapFixture {
	use ResourceMapTrait;
}
