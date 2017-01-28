<?php
namespace tests\infrastructure\urls\Url;
use mocks\infrastructure\urls\UrlParserFixture;
use vsc\infrastructure\urls\Url;

/**
 * @covers \vsc\infrastructure\urls\Url::__toString()
 */
class __toString extends \BaseUnitTest
{
	public function testEmpty__toString()
	{
		$sUrl = '';
		$o = new Url();
		$o->setHost($sUrl);
		$this->assertEquals($sUrl, $o->__toString());
		$this->assertEquals($sUrl, (string)$o);

		$sUrl = '192.168.1.1';
		$o = new Url();
		$o->setHost($sUrl);
		$this->assertEquals('http://' . $sUrl, $o->__toString());
		$this->assertEquals('http://' . $sUrl, (string)$o);

		$sUrl = '//localhost';
		$o = new Url();
		$o->setHost($sUrl);
		$this->assertEquals($sUrl . '/', $o->__toString());
		$this->assertEquals($sUrl . '/', (string)$o);

		$sUrl = '//192.168.1.1';
		$o = new Url();
		$o->setHost($sUrl);
		$this->assertEquals($sUrl, $o->__toString());
		$this->assertEquals($sUrl, (string)$o);

		$sUrl = 'localhost';
		$o = new Url();
		$o->setHost($sUrl);
		$this->assertEquals($sUrl . '/', $o->__toString());
		$this->assertEquals($sUrl . '/', (string)$o);

		$sUrl = '192.168.1.1';
		$o = new Url();
		$o->setHost($sUrl);
		$this->assertEquals($sUrl, $o->__toString());
		$this->assertEquals($sUrl, (string)$o);
	}
}
