<?php
namespace res\infrastructure\String;

use vsc\infrastructure\String;

/**
 * Class stripTagsTest
 * @package res\infrastructure\String
 * @covers \vsc\infrastructure\String::stripTags()
 */
class stripTagsTest extends \PHPUnit_Framework_TestCase {

	public function testBasicStripTags() {
		$test =<<<START
<div>Lorem <span>ipsum</span> dolor <a href="test">sic</a> amet.</div>
START;
;
		$this->assertEquals(strip_tags($test), String::stripTags($test));
		$this->assertEquals('Lorem ipsum dolor sic amet.', String::stripTags($test));
	}
}
