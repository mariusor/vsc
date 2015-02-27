<?php
namespace res\infrastructure\String;

use vsc\infrastructure\String;

/**
 * Class encodeEntitiesTest
 * @package res\infrastructure\String
 * @covers \vsc\infrastructure\String::encodeEntities()
 */
class encodeEntitiesTest extends \PHPUnit_Framework_TestCase {

	public function testUseless() {
		$sString = 'ana are mere gigel <a /> ';
		$this->assertEquals(htmlentities($sString, ENT_QUOTES, 'UTF-8'), String::encodeEntities($sString));
	}
}
