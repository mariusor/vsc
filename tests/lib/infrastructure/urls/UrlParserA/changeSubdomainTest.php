<?php
namespace lib\infrastructure\urls\UrlParserA;
use vsc\infrastructure\urls\UrlParserA;

/**
 * Class changeSubdomainTest
 * @package lib\infrastructure\urls\UrlParserA
 * @covers \vsc\infrastructure\urls\UrlParserA::changeSubdomain()
 */
class changeSubdomainTest extends \PHPUnit_Framework_TestCase {

	public function testBasicChangeSubdomain() {
		$o = new UrlParserA_underTest_changeSubdomain('http://dev.local.git/');
		$this->assertEquals('staging.local.git', $o->changeSubdomain('staging'));
	}
}

class UrlParserA_underTest_changeSubdomain extends UrlParserA {

}
