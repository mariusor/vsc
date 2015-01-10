<?php
namespace tests\lib\application\sitemaps\MappingA;
use vsc\application\sitemaps\MappingA;

/**
 * @covers \vsc\application\sitemaps\MappingA::isStatic()
 */
class isStatic extends \PHPUnit_Framework_TestCase
{
	public function testNotStatic()
	{
		$o = new MappingA_underTest_isStatic();
		$this->assertFalse($o->isStatic());
	}
}

class MappingA_underTest_isStatic extends MappingA {
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
