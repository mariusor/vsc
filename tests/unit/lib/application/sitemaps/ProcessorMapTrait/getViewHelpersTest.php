<?php
namespace tests\lib\application\sitemaps\ProcessorMapTrait;
use vsc\application\sitemaps\MappingA;
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

class ProcessorMapT_underTest_getViewHelpers extends MappingA {
	use ProcessorMapTrait;
}
