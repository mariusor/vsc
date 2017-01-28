<?php
namespace tests\application\sitemaps\MappingA;
use mocks\application\sitemaps\MapFixture;

/**
 * @covers \vsc\application\sitemaps\MappingA::setUrl()
 */
class setUrl extends \BaseUnitTest
{
	public function testBasicSetUrl ()
	{
		$o = new MappingA_underTest_setUrl();
		$sTest = '/test/';
		$o->setUrl($sTest);

		$this->assertEquals($sTest, $o->getUrl()->getPath());
	}

	public function testSetUrl ()
	{
		$o = new MappingA_underTest_setUrl();
		$sTest = 'http://example.com/test/';
		$o->setUrl($sTest);

		$this->assertEquals('/test/', $o->getUrl()->getPath());
	}
}

class MappingA_underTest_setUrl extends MapFixture {
	public function __construct ($sPath = null, $sRegex = null) {
		if (is_null($sPath)) {
			$sPath = __FILE__;
		}
		if (is_null($sRegex)) {
			$sRegex = '/test';
		}
		parent::__construct($sPath, $sRegex);
	}
}
