<?php
namespace tests\application\sitemaps\ProcessorMapTrait;
use mocks\application\sitemaps\MapFixture;
use vsc\application\sitemaps\ProcessorMapTrait;

/**
 * @covers \vsc\application\sitemaps\ProcessorMapTrait::getViewHelpers()
 */
class getViewHelpers extends \BaseUnitTest
{
	public function testEmptyAtInitialization()
	{
		$o = new ProcessorMapT_underTest_getViewHelpers(__FILE__, '.*');
		$this->assertEmpty($o->getViewHelpers());
	}
}

class ProcessorMapT_underTest_getViewHelpers extends MapFixture {
	use ProcessorMapTrait;
}
