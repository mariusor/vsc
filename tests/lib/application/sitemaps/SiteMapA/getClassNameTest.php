<?php
namespace tests\lib\application\sitemaps\SiteMapA;
use vsc\application\sitemaps\SiteMapA;

/**
 * @covers \vsc\application\sitemaps\SiteMapA::getClassName()
 */
class getClassName extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$sProcessorPath = VSC_FIXTURE_PATH . 'application/processors/ProcessorFixture.php';
		$this->assertEquals('stdClass', SiteMapA::getClassName($sProcessorPath));
	}
}
