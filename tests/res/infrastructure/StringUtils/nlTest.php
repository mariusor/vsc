<?php
namespace res\infrastructure\StringUtils;

use vsc\infrastructure\StringUtils;

/**
 * Class nlTest
 * @package res\infrastructure\StringUtils
 * @coverage \vsc\infrastructure\StringUtils::nl()
 */
class nlTest extends \PHPUnit_Framework_TestCase {

	public function testBasicNl () {
		$this->assertEquals("\n",StringUtils::nl());
	}
}
