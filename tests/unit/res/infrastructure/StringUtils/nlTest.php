<?php
namespace res\infrastructure\StringUtils;

use vsc\infrastructure\StringUtils;

/**
 * Class nlTest
 * @package res\infrastructure\StringUtils
 * @coverage \vsc\infrastructure\StringUtils::nl()
 */
class nlTest extends \BaseUnitTest {

	public function testBasicNl () {
		$this->assertEquals("\n",StringUtils::nl());
	}
}
