<?php
namespace tests\lib\application\sitemaps\ProcessorMapT;
use vsc\application\sitemaps\MappingA;
use vsc\application\sitemaps\ProcessorMapT;

/**
 * @covers \vsc\application\sitemaps\ProcessorMapT::getResponseStatus()
 */
class getResponseStatus extends \PHPUnit_Framework_TestCase
{
	public function testEmptyAtInitialization()
	{
		$o = new ProcessorMapT_underTest_getResponseStatus(__FILE__, '.*');
		$this->assertNull($o->getResponseStatus());
	}
}

class ProcessorMapT_underTest_getResponseStatus extends MappingA {
	use ProcessorMapT;
}
