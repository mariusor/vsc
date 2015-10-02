<?php
/**
 * @author Marius Orcsik <marius@habarnam.ro>
 * @created 2015-07-03
 */
namespace tests\infrastructure\urls;

use vsc\infrastructure\urls\Url;

/**
 * Class getFragmentTest
 * @package tests\infrastructure\urls
 * @covers vsc\infrastructure\urls\Url::getFragment()
 */
class getFragmentTest extends \PHPUnit_Framework_TestCase
{

	public function testInstantiationIsNull () {
		$url = new Url();
		$this->assertNull($url->getFragment());
	}
}
