<?php
namespace res\infrastructure\String;
use vsc\infrastructure\String;

/**
 * Class br2nlTest
 * @package res\infrastructure\String
 * @covers \vsc\infrastructure\String::br2nl()
 */
class br2nlTest extends \PHPUnit_Framework_TestCase {

	public function testBasicNl2Br () {
		$test =<<<ST
Ana are
mere.
ST;
		$this->assertEquals(nl2br($test),String::br2nl(nl2br($test)));
	}
}
