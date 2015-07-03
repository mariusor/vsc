<?php
/**
 * @author Marius Orcsik <marius.orcsik@rocket-internet.de>
 * @copyright Copyright (c) 2015 Rocket Internet SE, Johannisstraße 20, 10117 Berlin, http://www.rocket-internet.de
 * @created 2015-07-03
 */
namespace tests\infrastructure\urls\Url;

use vsc\infrastructure\urls\Url;

/**
 * Class isValidSchemeTest
 * @package tests\infrastructure\urls\Url
 * @covers vsc\infrastructure\urls\Url::isValidScheme()
 */
class isValidSchemeTest extends \PHPUnit_Framework_TestCase
{
	public function testBasicValidSchemes () {
		$mirror = new \ReflectionClass(Url::class);
		$validSchemes = $mirror->getStaticProperties()['validSchemes'];
		foreach ($validSchemes as $scheme) {
			$this->assertTrue(Url::isValidScheme($scheme));
		}
	}
}
