<?php
/**
 * @author Marius Orcsik <marius@habarnam.ro>
 * @created 2015-07-03
 */
namespace tests\infrastructure\urls;

use vsc\infrastructure\urls\Url;

/**
 * Class hasQueryTest
 * @package tests\infrastructure\urls
 * @covers vsc\infrastructure\urls\Url::hasQuery()
 */
class hasQueryTest extends \BaseUnitTest
{
	public function testFalseAtInstantiation () {
		$url = new Url();
		$this->assertFalse($url->hasQuery());
	}
}
