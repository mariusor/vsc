<?php
/**
 * @author Marius Orcsik <marius@habarnam.ro>
 * @created 2015-07-03
 */
namespace tests\infrastructure\urls;

use vsc\infrastructure\urls\Url;

/**
 * Class getHostTest
 * @package tests\infrastructure\urls
 * @covers vsc\infrastructure\urls\Url::getHost()
 */
class getHostTest extends \BaseUnitTest
{
	public function testInstantiationIsNull () {
		$url = new Url();
		$this->assertNull($url->getHost());
	}
}
