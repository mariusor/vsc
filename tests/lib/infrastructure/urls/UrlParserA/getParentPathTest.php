<?php
namespace tests\lib\infrastructure\urls\UrlParserA;
use fixtures\infrastructure\urls\UrlParserA_underTest;

/**
 * @covers \vsc\infrastructure\urls\UrlParserA::getParentPath
 */
class getParentPathTest extends \PHPUnit_Framework_TestCase {
	public function testGetParentPath () {
		$aUrlComponents = array (
			'scheme'	=> '',
			'host'		=> '',
			'user'		=> '',
			'pass'		=> '',
			'path'		=> __FILE__,
			'query'		=> array(),
			'fragment'	=> ''
		);
		$sUrl = UrlParserA_underTest::makeUrl($aUrlComponents);
		$oUrl = new UrlParserA_underTest($sUrl);

		$this->assertEquals(dirname(__FILE__), $oUrl->getParentPath(1));
	}

	/**
	 * @FIXME - this test, and the method are faulty at a first glance
	 */
	public function testGetParentPathWithAbsolutePath () {
		$sUrl = '/test/ana/../../rest/application/./processors/RESTProcessorA/validContentTypeTest.php';
		$oUrl = new UrlParserA_underTest($sUrl);

		$this->assertEquals('/rest/application', $oUrl->getParentPath(3));
	}

	/**
	 * @FIXME - this test, and the method are faulty at a first glance
	 */
	public function testGetParentPathWithRelativePath () {
		$sUrl = '/test/ana/../../rest/application/./processors/RESTProcessorA/validContentTypeTest.php';
		$oUrl = new UrlParserA_underTest($sUrl);

		$this->assertEquals('/rest/application', $oUrl->getParentPath(3));
	}
}
