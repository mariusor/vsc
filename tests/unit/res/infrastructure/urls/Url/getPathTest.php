<?php
/**
 * @author Marius Orcsik <marius@habarnam.ro>
 * @created 2015-07-03
 */
namespace tests\infrastructure\urls;

use vsc\infrastructure\urls\Url;

/**
 * Class getPathTest
 * @package tests\infrastructure\urls
 * @covers vsc\infrastructure\urls\Url::getPath()
 */
class getPathTest extends \BaseUnitTest
{
	public function testInstantiationIsNull () {
		$url = new Url();
		$this->assertEquals('', $url->getPath());
	}
}
