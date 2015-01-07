<?php
namespace tests\lib\application\sitemaps\MappingA;
use vsc\application\sitemaps\MappingA;

/**
 * @covers \vsc\application\sitemaps\MappingA::addSetting()
 */
class addSetting extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$sVar = 'test';
		$sVal = uniqid('test:');

		$o = new MappingA_underTest_addSetting();

		$o->addSetting($sVar, $sVal);
		$this->assertEquals($sVal, $o->getSetting($sVar));
	}
}

class MappingA_underTest_addSetting extends MappingA {
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
