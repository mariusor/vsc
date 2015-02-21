<?php
/**
 * Created by PhpStorm.
 * User: habarnam
 * Date: 2/21/15
 * Time: 7:53 PM
 */

namespace res\application\sitemaps\ClassMap;

use fixtures\application\processors\ProcessorFixture;
use vsc\application\sitemaps\ClassMap;

/**
 * Class mapsTest
 * @package res\application\sitemaps\ClassMap
 * @covers \vsc\application\sitemaps\ClassMap::maps()
 */
class mapsTest extends \PHPUnit_Framework_TestCase {

	public function testBasicMaps ()
	{
		$o = new ClassMap(ProcessorFixture::class, '.*');
		$p = new ProcessorFixture();

		$this->assertTrue($o->maps($p));
	}
}
