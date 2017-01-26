<?php
namespace tests\application\sitemaps\ProcessorMapTrait;
use mocks\application\sitemaps\MapFixture;
use vsc\application\sitemaps\ProcessorMapTrait;

/**
 * @covers \vsc\application\sitemaps\ProcessorMapTrait::getResponse()
 */
class getResponse extends \BaseUnitTest
{
	public function testEmptyAtInitialization()
	{
		$o = new ProcessorMapT_underTest_getResponse(__FILE__, '.*');
		$this->assertNull($o->getResponse());
	}
}

class ProcessorMapT_underTest_getResponse extends MapFixture {
	use ProcessorMapTrait;
}
