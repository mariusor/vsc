<?php
namespace tests\lib\application\sitemaps\ProcessorMapTrait;
use mocks\application\sitemaps\MapFixture;
use vsc\application\sitemaps\ProcessorMapTrait;

/**
 * @covers \vsc\application\sitemaps\ProcessorMapTrait::getResponseStatus()
 */
class getResponseStatus extends \BaseUnitTest
{
	public function testEmptyAtInitialization()
	{
		$o = new ProcessorMapT_underTest_getResponseStatus(__FILE__, '.*');
		$this->assertNull($o->getResponseStatus());
	}
}

class ProcessorMapT_underTest_getResponseStatus extends MapFixture {
	use ProcessorMapTrait;
}
