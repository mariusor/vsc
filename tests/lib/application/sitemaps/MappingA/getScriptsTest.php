<?php
namespace tests\lib\application\sitemaps\MappingA;
use vsc\application\sitemaps\MappingA;

/**
 * @covers \vsc\application\sitemaps\MappingA::getScripts()
 */
class getScripts extends \PHPUnit_Framework_TestCase
{
	public function testEmptyAtInitialize ()
	{
		$o = new MappingA_underTest_getScripts();
		$this->assertNull($o->getScripts());
	}
}

class MappingA_underTest_getScripts extends MappingA {
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
