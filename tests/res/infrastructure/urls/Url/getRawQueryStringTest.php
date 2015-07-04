<?php
/**
 * @author Marius Orcsik <marius.orcsik@rocket-internet.de>
 * @copyright Copyright (c) 2015 Rocket Internet SE, Johannisstraße 20, 10117 Berlin, http://www.rocket-internet.de
 * @created 2015-07-03
 */
namespace res\infrastructure\urls\Url;

use vsc\infrastructure\urls\Url;

/**
 * Class getRawQueryStringTest
 * @package tests\infrastructure\urls
 * @covers vsc\infrastructure\urls\Url::getRawQueryString()
 */
class getRawQueryStringTest extends \PHPUnit_Framework_TestCase
{
	public function testGetQueryString () {
		$value = [
			'ana' => 'mere',
			'test' => 123
		];
		$oUrl = new Url();
		$oUrl->setQuery($value);

		$this->assertEquals('ana=mere&test=123', $oUrl->getRawQueryString(false));
		$this->assertEquals('ana=mere&amp;test=123', $oUrl->getRawQueryString());
	}
}
