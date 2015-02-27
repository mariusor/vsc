<?php
namespace res\infrastructure\String;

use vsc\infrastructure\String;

/**
 * Class nlTest
 * @package res\infrastructure\String
 * @coverage \vsc\infrastructure\String::nl()
 */
class nlTest extends \PHPUnit_Framework_TestCase {

	public function testBasicNl () {
		$this->assertEquals("\n",String::nl());
	}
}
