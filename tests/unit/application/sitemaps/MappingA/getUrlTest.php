<?php
namespace tests\application\sitemaps\MappingA;
use mocks\application\sitemaps\MapFixture;
use vsc\infrastructure\urls\Url;

/**
 * @covers \vsc\application\sitemaps\MappingA::getUrl()
 */
class getUrl extends \BaseUnitTest
{
	public function testEmptyAtInitialize ()
	{
		$o = new MappingA_underTest_getUrl();
		$this->assertInstanceOf(Url::class, $o->getUrl());
	}

	public function testGetModuleUrl () {
		$o = new MappingA_underTest_getUrl(__FILE__, '/test/a:(\d{3})/');
		$o->setUrl('/test/a:123/');
		$this->assertEquals('/test/a:123/', $o->getUrl()->getPath());
	}
}

class MappingA_underTest_getUrl extends MapFixture {
	public function __construct ($sPath = null, $sRegex = null) {
		if (is_null($sPath)) {
			$sPath = __FILE__;
		}
		if (is_null($sRegex)) {
			$sRegex = '.*';
		}
		parent::__construct($sPath, $sRegex);
	}
}
