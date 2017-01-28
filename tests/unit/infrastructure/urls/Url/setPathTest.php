<?php
/**
 * @author Marius Orcsik <marius@habarnam.ro>
 * @created 2015-07-03
 */
namespace tests\infrastructure\urls;

use vsc\infrastructure\urls\Url;

/**
 * Class setPathTest
 * @package tests\infrastructure\urls
 * @covers vsc\infrastructure\urls\Url::setPath()
 */
class setPathTest extends \BaseUnitTest
{
	public function testBasicSetPath () {
		$value = uniqid('test:');
		$url = new Url();
		$url->setPath($value);
		$this->assertEquals($value . '/', $url->getPath());
	}
}
