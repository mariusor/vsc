<?php
namespace tests\lib\application\sitemaps\MappingA;
use vsc\application\sitemaps\MappingA;

/**
 * @covers \vsc\application\sitemaps\MappingA::addLink()
 */
class addLink extends \PHPUnit_Framework_TestCase
{
	public function testBasicAddLink()
	{
		$sType = 'application/png';
		$aData = array();

		$aVerify = array ($sType=>array($aData));
		$o = new MappingA_underTest_addLink();
		$o->addLink($sType, array());

		$this->assertEquals ($aVerify, $o->getLinks($sType));
	}
}

class MappingA_underTest_addLink extends MappingA {
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
