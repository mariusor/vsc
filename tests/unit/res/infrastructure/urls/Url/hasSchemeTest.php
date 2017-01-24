<?php
/**
 * @author Marius Orcsik <marius@habarnam.ro>
 * @created 2015-07-03
 */
namespace tests\infrastructure\urls;

use vsc\infrastructure\urls\Url;

/**
 * Class hasSchemeTest
 * @package tests\infrastructure\urls
 * @covers vsc\infrastructure\urls\Url::hasScheme()
 */
class hasSchemeTest extends \BaseUnitTest
{
	public function testFalseAtInstantiation () {
		$url = new Url();
		$this->assertFalse($url->hasScheme());
	}
}
