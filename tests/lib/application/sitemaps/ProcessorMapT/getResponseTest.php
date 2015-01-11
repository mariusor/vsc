<?php
namespace tests\lib\application\sitemaps\ProcessorMapT;
use vsc\application\sitemaps\MappingA;
use vsc\application\sitemaps\ProcessorMapT;

/**
 * @covers \vsc\application\sitemaps\ProcessorMapT::getResponse()
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
	use ProcessorMapT;
}
