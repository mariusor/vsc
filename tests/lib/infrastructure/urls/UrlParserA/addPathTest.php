<?php
namespace tests\lib\infrastructure\urls\UrlParserA;
use fixtures\infrastructure\urls\UrlParserA_underTest;

/**
 * @covers \vsc\infrastructure\urls\UrlParserA::addPath
 */
class addPathTest extends \PHPUnit_Framework_TestCase {

	public function testAddPath () {
		$sLocalHost = 'http://localhost';
		$sStr = 'ana/are/mere';

		$oUrl = new UrlParserA_underTest($sLocalHost);
		$oUrl->addPath($sStr);

		$this->assertEquals($sLocalHost . '/' . $sStr, $oUrl->getCompleteUri(true));
	}

	public function testAddRelativePathWithParentDirectory () {
		$sLocalHost = 'http://localhost';
		$sStr = 'ana/../are/mere';

		$oUrl = new UrlParserA_underTest($sLocalHost);
		$oUrl->addPath($sStr);

		$sParentStr = substr($sStr, strpos($sStr, '../') + strlen ('../'));
		$this->assertEquals($sLocalHost . '/' . $sParentStr, $oUrl->getCompleteUri(true));
	}

	public function testAddRelativePathWithCurrentDirectory () {
		$sLocalHost = 'http://localhost';
		$sStr = 'ana/./are/mere';

		$oUrl = new UrlParserA_underTest($sLocalHost);
		$oUrl->addPath($sStr);

		$sCurrentStr = str_replace('./', '', $sStr);
		$this->assertEquals($sLocalHost . '/' . $sCurrentStr, $oUrl->getCompleteUri(true));
	}

}
