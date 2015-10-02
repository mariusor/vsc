<?php
namespace tests\lib\application\sitemaps\MappingA;
use vsc\application\sitemaps\MappingA;

/**
 * @covers \vsc\application\sitemaps\MappingA::getStyles()
 */
class getStyles extends \PHPUnit_Framework_TestCase
{
	public function testEmptyAtInitialize ()
	{
		$o = new MappingA_underTest_getStyles();
		$this->assertEquals([], $o->getStyles());
	}
}

class MappingA_underTest_getStyles extends MappingA {
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
