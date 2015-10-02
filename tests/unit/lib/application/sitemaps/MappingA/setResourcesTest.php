<?php
namespace tests\lib\application\sitemaps\MappingA;
use vsc\application\sitemaps\MappingA;

/**
 * @covers \vsc\application\sitemaps\MappingA::setResources()
 */
class setResources extends \PHPUnit_Framework_TestCase
{
	public function testBasicSetResources ()
	{
		$o = new MappingA_underTest_setResources();

		$aTest = ['test' => uniqid('test:')];
		$o->setResources($aTest);
		$this->assertEquals($aTest, $o->getResources());
	}
}

class MappingA_underTest_setResources extends MappingA {
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
