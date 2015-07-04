<?php
/**
 * @author Marius Orcsik <marius.orcsik@rocket-internet.de>
 * @copyright Copyright (c) 2015 Rocket Internet SE, Johannisstraße 20, 10117 Berlin, http://www.rocket-internet.de
 * @created 2015-07-03
 */
namespace tests\infrastructure\urls\Url;

use vsc\infrastructure\urls\Url;

/**
 * Class getUrlTest
 * @package tests\infrastructure\urls\Url
 * @covers vsc\infrastructure\urls\Url::getUrl()
 */
class getUrlTest extends \PHPUnit_Framework_TestCase
{
	public function testInstantiationIsEmptyString () {
		$url = new Url_underTest_getUrl();
		$this->assertEquals('', $url->getUrl());
	}

	public function testFullUrl () {
		$url = new Url_underTest_getUrl();
		$url->setScheme('https');
		$url->setHost('example.com');
		$url->setPath('/');
		$url->setQuery(['ana' => 'mere', 'test' => 123]);
		$url->setFragment('hash');
		$this->assertEquals('https://example.com/ana=mere&amp;test=123#hash', $url->getUrl());
	}
}

class Url_underTest_getUrl extends Url {
	public function getUrl () {
		return parent::getUrl();
	}
}
