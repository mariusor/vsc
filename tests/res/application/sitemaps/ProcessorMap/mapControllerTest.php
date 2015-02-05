<?php
namespace tests\res\application\sitemaps\ProcessorMap;
use vsc\application\sitemaps\ProcessorMap;
use vsc\application\sitemaps\MappingA;

/**
 * @covers \vsc\application\sitemaps\ProcessorMap::mapController()
 */
class mapController extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$o = new ProcessorMap(__FILE__, '.*');
		$map = $o->mapController('.*', __FILE__);

		$this->assertInstanceOf(MappingA::class, $map);
	}
}
