<?php
namespace tests\lib\infrastructure\urls\UrlParserA;
use fixtures\infrastructure\urls\UrlParserA_underTest;

/**
 * @covers \vsc\infrastructure\urls\UrlParserA::addPathTest
 */
class addPathTest extends \PHPUnit_Framework_TestCase {

	public function testAddPath () {
		$sLocalHost = 'http://localhost';
		$sStr = 'ana/are/mere';

		$oUrl = new UrlParserA_underTest($sLocalHost);
		$oUrl->addPath($sStr);

		$this->assertEquals($oUrl->getCompleteUri(true), $sLocalHost . '/' . $sStr . '/');
	}

	public function testAddRelativePathWithParentDirectory () {
		$sLocalHost = 'http://localhost';
		$sStr = 'ana/../are/mere';

		$oUrl = new UrlParserA_underTest($sLocalHost);
		$oUrl->addPath($sStr);

		$sParentStr = substr($sStr, strpos($sStr, '../') + strlen ('../'));
		$this->assertEquals($oUrl->getCompleteUri(true), $sLocalHost . '/' . $sParentStr . '/');
	}

	public function testAddRelativePathWithCurrentDirectory () {
		$sLocalHost = 'http://localhost';
		$sStr = 'ana/./are/mere';

		$oUrl = new UrlParserA_underTest($sLocalHost);
		$oUrl->addPath($sStr);

		$sCurrentStr = str_replace('./', '', $sStr);
		$this->assertEquals($oUrl->getCompleteUri(true), $sLocalHost . '/' . $sCurrentStr . '/');
	}

}
