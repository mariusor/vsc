<?php
namespace tests\application\sitemaps\SiteMapA;
use vsc\application\sitemaps\SiteMapA;

/**
 * @covers \vsc\application\sitemaps\SiteMapA::getClassName()
 */
class getClassName extends \BaseUnitTest
{
	public function testBasicGetClassName()
	{
		$sProcessorPath = VSC_MOCK_PATH . 'application/processors/ProcessorFixture.php';
		$this->assertEquals('stdClass', SiteMapA::getClassName($sProcessorPath));
	}
}
