<?php
namespace res\infrastructure\StringUtils;
use vsc\infrastructure\StringUtils;

/**
 * Class br2nlTest
 * @package res\infrastructure\StringUtils
 * @covers \vsc\infrastructure\StringUtils::br2nl()
 */
class br2nlTest extends \BaseUnitTest {

	public function testBasicNl2Br () {
		$test =<<<ST
Ana are
mere.
ST;
		$this->assertEquals(nl2br($test),StringUtils::br2nl(nl2br($test)));
	}
}
