<?php
namespace tests\lib\application\sitemaps\MappingA;
use vsc\application\sitemaps\MappingA;

/**
 * @covers \vsc\application\sitemaps\MappingA::setUrl()
 */
class setUrl extends \PHPUnit_Framework_TestCase
{
	public function testBasicSetUrl ()
	{
		$o = new MappingA_underTest_setUrl();
		$sTest = 'test';
		$o->setUrl($sTest);

		$this->assertEquals('/' . $sTest . '/', $o->getUrl()->getPath());
	}

	public function testSetUrl ()
	{
		$o = new MappingA_underTest_setUrl();
		$sTest = 'http://example.com/test';
		$o->setUrl($sTest);

		$this->assertEquals('/test/', $o->getUrl()->getPath());
	}
}

class MappingA_underTest_setUrl extends MappingA {
	public function __construct ($sPath = null, $sRegex = null) {
		if (is_null($sPath)) {
			$sPath = __FILE__;
		}
		if (is_null($sRegex)) {
			$sRegex = 'test';
		}
		parent::__construct($sPath, $sRegex);
	}
}
