<?php
/**
 * @author Marius Orcsik <marius.orcsik@rocket-internet.de>
 * @copyright Copyright (c) 2015 Rocket Internet SE, Johannisstraße 20, 10117 Berlin, http://www.rocket-internet.de
 * @created 2015-07-03
 */
namespace tests\infrastructure\urls\Url;

use vsc\infrastructure\urls\Url;

/**
 * Class setRawQueryTest
 * @package tests\infrastructure\urls\Url
 * @covers vsc\infrastructure\urls\Url::setRawQuery()
 */
class setRawQueryTest extends \PHPUnit_Framework_TestCase
{
	public function testBasicSetRawQuery () {
		$value = 'ana=mere&test=123';
		$test = [
			'ana' => 'mere',
			'test' => 123
		];
		$url = new Url();
		$url->setRawQuery($value);
		$this->assertEquals($test, $url->getQuery());
	}
}
