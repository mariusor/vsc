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
 * @covers vsc\infrastructure\urls\Url::setScheme()
 */
class setSchemeTest extends \BaseUnitTest
{
	public function testBasicSetScheme () {
		$value = 'https';
		$url = new Url();
		$url->setScheme($value);
		$this->assertEquals($value, $url->getScheme());
	}
}
