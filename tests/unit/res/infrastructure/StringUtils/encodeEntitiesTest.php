<?php
namespace res\infrastructure\StringUtils;

use vsc\infrastructure\StringUtils;

/**
 * Class encodeEntitiesTest
 * @package res\infrastructure\StringUtils
 * @covers \vsc\infrastructure\StringUtils::encodeEntities()
 */
class encodeEntitiesTest extends \PHPUnit_Framework_TestCase {

	public function testUseless() {
		$sString = 'ana are mere gigel <a /> ';
		$this->assertEquals(htmlentities($sString, ENT_QUOTES, 'UTF-8'), StringUtils::encodeEntities($sString));
	}
}
