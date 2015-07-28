<?php
/**
 * @author Marius Orcsik <marius@habarnam.ro>
 * @created 2015-07-03
 */
namespace tests\infrastructure\urls;

use vsc\infrastructure\urls\Url;

/**
 * Class setQueryTest
 * @package tests\infrastructure\urls
 * @covers vsc\infrastructure\urls\Url::setQuery()
 */
class setQueryTest extends \PHPUnit_Framework_TestCase
{
	public function testBasicSetQuery () {
		$value = [
			'ana' => 'mere',
			'test' => 123
		];
		$url = new Url();
		$url->setQuery($value);
		$this->assertEquals($value, $url->getQuery());
	}
}
