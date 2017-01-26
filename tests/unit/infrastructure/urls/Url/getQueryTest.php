<?php
/**
 * @author Marius Orcsik <marius@habarnam.ro>
 * @created 2015-07-03
 */
namespace tests\infrastructure\urls;

use vsc\infrastructure\urls\Url;

/**
 * Class getQueryTest
 * @package tests\infrastructure\urls
 * @covers vsc\infrastructure\urls\Url::getQuery
 */
class getQueryTest extends \BaseUnitTest
{
	public function testInstantiationIsNull () {
		$url = new Url();
		$this->assertEquals([], $url->getQuery());
	}

	public function testGetQuery () {
		$value = [
			'ana' => 'mere'
		];
		$oUrl = new Url ();
		$oUrl->setQuery($value);
		$this->assertEquals($value, $oUrl->getQuery());
	}
}
