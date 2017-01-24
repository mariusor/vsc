<?php
namespace tests\lib\application\sitemaps\MappingA;
use vsc\application\sitemaps\MappingA;

/**
 * @covers \vsc\application\sitemaps\MappingA::setTitle()
 */
class setTitle extends \BaseUnitTest
{
	public function testBasicSetTitle ()
	{
		$o = new MappingA_underTest_setTitle();
		$sTest = uniqid('test:');
		$o->setTitle($sTest);
		$this->assertEquals($sTest, $o->getTitle());
	}
}

class MappingA_underTest_setTitle extends MappingA {
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
