<?php
namespace tests\lib\application\sitemaps\MappingA;
use vsc\application\sitemaps\MappingA;

/**
 * @covers \vsc\application\sitemaps\MappingA::addScript()
 */
class addScript extends \PHPUnit_Framework_TestCase
{
	public function testAddScriptWithFullPath()
	{
		$sPath = __FILE__;

		$o = new MappingA_underTest_addScript();
		$o->addScript($sPath);

		$this->assertArraySubset(array($sPath), $o->getScripts());
	}

	public function testAddScriptWithRelativePath()
	{
		$sPath = basename(__FILE__);

		$o = new MappingA_underTest_addScript();
		$o->addScript($sPath);

		$this->assertArraySubset(array($sPath), $o->getScripts());
	}
}

class MappingA_underTest_addScript extends MappingA {
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
