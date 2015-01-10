<?php
namespace tests\lib\application\sitemaps\MappingA;
use vsc\application\sitemaps\MappingA;

/**
 * @covers \vsc\application\sitemaps\MappingA::setTaintedVars()
 */
class setTaintedVars extends \PHPUnit_Framework_TestCase
{
	public function testBasicSetTaintedVars ()
	{
		$o = new MappingA_underTest_setTaintedVars();
		$aTest = [
			'test' => uniqid('test:'),
			'ana' => 'mere'
		];
		$o->setTaintedVars($aTest);
		$this->assertEquals($aTest, $o->getTaintedVars());
	}
}

class MappingA_underTest_setTaintedVars extends MappingA {
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
