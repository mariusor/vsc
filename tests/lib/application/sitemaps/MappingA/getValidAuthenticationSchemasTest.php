<?php
namespace tests\lib\application\sitemaps\MappingA;
use vsc\application\sitemaps\MappingA;
use vsc\presentation\requests\HttpAuthenticationA;

/**
 * @covers \vsc\application\sitemaps\MappingA::getValidAuthenticationSchemas()
 */
class getValidAuthenticationSchemas extends \PHPUnit_Framework_TestCase
{
	public function testEmptyAtInitialize ()
	{
		$o = new MappingA_underTest_getValidAuthenticationSchemas();
		$this->assertEquals([], $o->getValidAuthenticationSchemas());
	}
}

class MappingA_underTest_getValidAuthenticationSchemas extends MappingA {
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
