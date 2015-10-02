<?php
namespace tests\lib\application\sitemaps\ProcessorMapTrait;
use vsc\application\sitemaps\MappingA;
use vsc\application\sitemaps\ProcessorMapTrait;

/**
 * @covers \vsc\application\sitemaps\ProcessorMapTrait::getResponse()
 */
class getResponse extends \PHPUnit_Framework_TestCase
{
	public function testEmptyAtInitialization()
	{
		$o = new ProcessorMapT_underTest_getResponse(__FILE__, '.*');
		$this->assertNull($o->getResponse());
	}
}

class ProcessorMapT_underTest_getResponse extends MappingA {
	use ProcessorMapTrait;
}
