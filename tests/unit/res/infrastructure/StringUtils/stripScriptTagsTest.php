<?php
namespace res\infrastructure\StringUtils;

use vsc\infrastructure\StringUtils;

/**
 * Class stripScriptTagsTest
 * @package res\infrastructure\StringUtils
 * @covers \vsc\infrastructure\StringUtils::stripScriptTags()
 */
class stripScriptTagsTest extends \PHPUnit_Framework_TestCase {

	public function testBasicStripScriptTags() {
		$test =<<<START
<div>Lorem <span>ipsum</span> dolor <a href="test">sic</a> amet.</div>
<script>alert('bitch');</script>
START;
		;
		$this->assertFalse(stristr(StringUtils::stripScriptTags($test), 'bitch'));
		$this->assertFalse(stristr(StringUtils::stripScriptTags($test), 'alert'));
		$this->assertFalse(stristr(StringUtils::stripScriptTags($test), '<script>alert(\'bitch\');</script>'));
	}
}
