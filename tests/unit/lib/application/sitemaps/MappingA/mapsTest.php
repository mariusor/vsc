<?php
namespace lib\application\sitemaps\MappingA;

use mocks\application\processors\ProcessorFixture;
use vsc\application\sitemaps\MappingA;

/**
 * Class mapsTest
 * @package lib\application\sitemaps\MappingA
 * @covers \vsc\application\sitemaps\MappingA::maps()
 */
class mapsTest extends \BaseUnitTest {

	public function testBasicMaps ()
	{
		$o = new MappingA_underTest_maps(VSC_MOCK_PATH . 'application/processors/ProcessorFixture.php', '.*');
		$p = new ProcessorFixture();

		$this->assertTrue($o->maps($p));
	}
}

class MappingA_underTest_maps extends MappingA { }
