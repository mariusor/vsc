<?php
namespace res\application\sitemaps\ClassMap;

use mocks\application\processors\ProcessorFixture;
use vsc\application\sitemaps\ClassMap;

/**
 * Class mapsTest
 * @package res\application\sitemaps\ClassMap
 * @covers \vsc\application\sitemaps\ClassMap::maps()
 */
class mapsTest extends \BaseUnitTest {

	public function testBasicMaps ()
	{
		$o = new ClassMap(ProcessorFixture::class, '.*');
		$p = new ProcessorFixture();

		$this->assertTrue($o->maps($p));
	}
}
