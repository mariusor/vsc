<?php
namespace tests\lib\application\sitemaps\MappingA;
use vsc\application\sitemaps\MappingA;

/**
 * @covers \vsc\application\sitemaps\MappingA::getMetas()
 */
class getMetas extends \PHPUnit_Framework_TestCase
{
	public function testEmptyAtInitialization()
	{
		$o = new MappingA_underTest_getMetas();
		$this->assertEmpty($o->getMetas());
	}

	public function testGetSpecificMeta()
	{
		$sType = 'test';
		$sValue = uniqid('test:');

		$o = new MappingA_underTest_getMetas();
		$o->addMeta($sType, $sValue);

		$this->assertEquals($sValue, $o->getMetas($sType));
	}

	public function testGetAllMetaInfo()
	{
		$sType = 'test';
		$sValue = uniqid('test:');

		$aVerify = array ($sType => $sValue);
		$o = new MappingA_underTest_getMetas();
		$o->addMeta($sType, $sValue);

		$this->assertEquals($aVerify, $o->getMetas());
	}
}

class MappingA_underTest_getMetas extends MappingA {
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

