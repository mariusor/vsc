<?php
/**
 * @author Marius Orcsik <marius@habarnam.ro>
 * @created 2015-07-03
 */
namespace tests\infrastructure\urls;

use vsc\infrastructure\urls\Url;

/**
 * Class setSchemeTest
 * @package tests\infrastructure\urls
 * @covers \vsc\infrastructure\urls\Url::setScheme()
 */
class setSchemeTest extends \BaseUnitTest
{
	public function testSetSchemeNoHost () {
		$value = 'https';
		$url = new Url();
		$url->setScheme($value);
		$this->assertNull($url->getScheme());
	}

	public function testSetSchemeWithHost () {
		$value = 'https';
		$url = new Url();
		$url->setScheme($value);
		$url->setHost('random');

		$this->assertEquals($value . '://', $url->getScheme());
	}
}
