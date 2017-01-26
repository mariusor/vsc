<?php
/**
 * @author Marius Orcsik <marius@habarnam.ro>
 * @created 2015-07-03
 */
namespace tests\infrastructure\urls;

use vsc\infrastructure\urls\Url;

/**
 * Class setFragmentTest
 * @package tests\infrastructure\urls
 * @covers vsc\infrastructure\urls\Url::setFragment()
 */
class setFragmentTest extends \BaseUnitTest
{
	public function testBasicSetFragment () {
		$value = uniqid('test:');
		$url = new Url();
		$url->setFragment($value);
		$this->assertEquals($value, $url->getFragment());
	}
}
