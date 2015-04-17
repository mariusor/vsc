<?php
namespace tests\lib\presentation\views\ViewA;
use fixtures\presentation\views\testView;
use vsc\infrastructure\urls\UrlParserA;

/**
 * @covers \vsc\presentation\views\ViewA::getUriParser()
 */
class getUriParser extends \PHPUnit_Framework_TestCase
{
	public function testGetUriParser()
	{
		$o = new testView();

		$p = $o->getUriParser();

		$this->assertInstanceOf(UrlParserA::class, $p);
	}
}
