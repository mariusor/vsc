<?php
/**
 * @author Marius Orcsik <marius@habarnam.ro>
 * @created 2015-07-03
 */
namespace tests\infrastructure\urls\Url;

use vsc\infrastructure\urls\Url;

/**
 * Class setRawQueryTest
 * @package tests\infrastructure\urls\Url
 * @covers vsc\infrastructure\urls\Url::setRawQuery()
 */
class setRawQueryTest extends \BaseUnitTest
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
