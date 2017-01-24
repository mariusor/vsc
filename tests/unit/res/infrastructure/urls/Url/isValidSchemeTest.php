<?php
/**
 * @author Marius Orcsik <marius@habarnam.ro>
 * @created 2015-07-03
 */
namespace tests\infrastructure\urls\Url;

use vsc\infrastructure\urls\Url;

/**
 * Class isValidSchemeTest
 * @package tests\infrastructure\urls\Url
 * @covers vsc\infrastructure\urls\Url::isValidScheme()
 */
class isValidSchemeTest extends \BaseUnitTest
{
	public function testBasicValidSchemes () {
		$mirror = new \ReflectionClass(Url::class);
		$validSchemes = $mirror->getStaticProperties()['validSchemes'];
		foreach ($validSchemes as $scheme) {
			$this->assertTrue(Url::isValidScheme($scheme));
		}
	}
}
