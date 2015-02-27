<?php
namespace res\infrastructure\String;

use vsc\infrastructure\String;

/**
 * Class stripScriptTagsTest
 * @package res\infrastructure\String
 * @covers \vsc\infrastructure\String::stripScriptTags()
 */
class stripScriptTagsTest extends \PHPUnit_Framework_TestCase {

	public function testBasicStripScriptTags() {
		$test =<<<START
<div>Lorem <span>ipsum</span> dolor <a href="test">sic</a> amet.</div>
<script>alert('bitch');</script>
START;
		;
		$this->assertFalse(stristr(String::stripScriptTags($test), 'bitch'));
		$this->assertFalse(stristr(String::stripScriptTags($test), 'alert'));
		$this->assertFalse(stristr(String::stripScriptTags($test), '<script>alert(\'bitch\');</script>'));
	}
}
