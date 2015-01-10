<?php
namespace tests\lib\application\sitemaps\MappingA;
use vsc\application\sitemaps\MappingA;

/**
 * @covers \vsc\application\sitemaps\MappingA::getHeaders()
 */
class getHeaders extends \PHPUnit_Framework_TestCase
{
	public function testEmptyAtInitialization()
	{
		$o = new MappingA_underTest_getHeaders();
		$this->assertEmpty($o->getHeaders());
	}

	public function testBasicSetHeader()
	{
		$o = new MappingA_underTest_getHeaders();
		$sHeader = 'test';
		$sValue = uniqid('test:');
		$o->addHeader($sHeader, $sValue);

		$this->assertArraySubset(array($sHeader => $sValue), $o->getHeaders());
	}
}

class MappingA_underTest_getHeaders extends MappingA {
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
