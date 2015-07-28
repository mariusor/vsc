<?php
/**
 * @author Marius Orcsik <marius@habarnam.ro>
 * @created 2015-07-03
 */
namespace tests\infrastructure\urls;

use vsc\infrastructure\urls\Url;

/**
 * Class hasFragmentTest
 * @package tests\infrastructure\urls
 * @covers vsc\infrastructure\urls\Url::hasFragment()
 */
class hasFragmentTest extends \PHPUnit_Framework_TestCase
{
	public function testFalseAtInstantiation () {
		$url = new Url();
		$this->assertFalse($url->hasFragment());
	}
}
