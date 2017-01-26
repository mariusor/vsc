<?php
/**
 * @author Marius Orcsik <marius@habarnam.ro>
 * @created 2015-07-03
 */
namespace tests\infrastructure\urls;

use vsc\infrastructure\urls\Url;

/**
 * Class hasHostTest
 * @package tests\infrastructure\urls
 * @covers vsc\infrastructure\urls\Url::hasHost()
 */
class hasHostTest extends \BaseUnitTest
{
	public function testFalseAtInstantiation () {
		$url = new Url();
		$this->assertFalse($url->hasHost());
	}
}
