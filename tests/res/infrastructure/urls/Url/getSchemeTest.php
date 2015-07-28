<?php
/**
 * @author Marius Orcsik <marius@habarnam.ro>
 * @created 2015-07-03
 */
namespace tests\infrastructure\urls;

use vsc\infrastructure\urls\Url;

/**
 * Class getSchemeTest
 * @package tests\infrastructure\urls
 * @covers vsc\infrastructure\urls\Url::getScheme()
 */
class getSchemeTest extends \PHPUnit_Framework_TestCase
{
	public function testInstantiationIsNull () {
		$url = new Url();
		$this->assertNull($url->getScheme());
	}
}
