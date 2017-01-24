<?php
/**
 * @author Marius Orcsik <marius@habarnam.ro>
 * @created 2015-07-03
 */
namespace res\infrastructure\urls\Url;

use vsc\infrastructure\urls\Url;

/**
 * Class getRawQueryStringTest
 * @package tests\infrastructure\urls
 * @covers vsc\infrastructure\urls\Url::getRawQueryString()
 */
class getRawQueryStringTest extends \BaseUnitTest
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
