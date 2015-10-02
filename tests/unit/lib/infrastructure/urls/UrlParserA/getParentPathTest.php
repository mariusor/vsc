<?php
namespace tests\lib\infrastructure\urls\UrlParserA;
use mocks\infrastructure\urls\UrlParserFixture;

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
		$sUrl = UrlParserFixture::makeUrl($aUrlComponents);
		$oUrl = new UrlParserFixture($sUrl);

		$this->assertEquals(dirname(__FILE__), $oUrl->getParentPath(1));
	}

	/**
	 * @FIXME - this test, and the method are faulty at a first glance
	 */
	public function testGetParentPathWithAbsolutePath () {
		$sUrl = '/test/ana/../../rest/application/./processors/RESTProcessorA/validContentTypeTest.php';
		$oUrl = new UrlParserFixture($sUrl);

		$this->assertEquals('/rest/application', $oUrl->getParentPath(3));
	}

	/**
	 * @FIXME - this test, and the method are faulty at a first glance
	 */
	public function testGetParentPathWithRelativePath () {
		$sUrl = '/test/ana/../../rest/application/./processors/RESTProcessorA/validContentTypeTest.php';
		$oUrl = new UrlParserFixture($sUrl);

		$this->assertEquals('/rest/application', $oUrl->getParentPath(3));
	}
}
