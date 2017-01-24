<?php
namespace tests\lib\application\sitemaps\MappingA;
use vsc\application\sitemaps\MappingA;

/**
 * @covers \vsc\application\sitemaps\MappingA::addHeader()
 */
class addHeader extends \BaseUnitTest
{
	public function testBasicSetHeader()
	{
		$o = new MappingA_underTest_addHeader();
		$sHeader = 'test';
		$sValue = uniqid('test:');
		$o->addHeader($sHeader, $sValue);

		$this->assertArraySubset(array($sHeader => $sValue), $o->getHeaders());
	}
}

class MappingA_underTest_addHeader extends MappingA {
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
