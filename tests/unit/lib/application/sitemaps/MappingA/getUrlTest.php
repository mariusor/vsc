<?php
namespace tests\lib\application\sitemaps\MappingA;
use vsc\application\sitemaps\MappingA;
use vsc\infrastructure\urls\Url;

/**
 * @covers \vsc\application\sitemaps\MappingA::getUrl()
 */
class getUrl extends \PHPUnit_Framework_TestCase
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

class MappingA_underTest_getUrl extends MappingA {
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
