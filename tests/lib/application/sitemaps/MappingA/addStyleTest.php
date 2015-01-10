<?php
namespace tests\lib\application\sitemaps\MappingA;
use vsc\application\sitemaps\MappingA;

/**
 * @covers \vsc\application\sitemaps\MappingA::addStyle()
 */
class addStyle extends \PHPUnit_Framework_TestCase
{
	public function testSetBasicStyle()
	{
		$sStyle = VSC_FIXTURE_PATH . 'static/fixture.css';
		$sMedia = 'screen';

		$o = new MappingA_underTest_addStyle();

		$o->addStyle($sStyle, $sMedia);
		$this->assertArraySubset([$sMedia => [$sStyle]], $o->getStyles($sMedia));
		$this->assertArraySubset([$sMedia => [$sStyle]], $o->getStyles());
	}
}

class MappingA_underTest_addStyle extends MappingA {
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
