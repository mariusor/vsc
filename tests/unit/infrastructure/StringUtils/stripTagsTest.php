<?php
namespace res\infrastructure\StringUtils;

use vsc\infrastructure\StringUtils;

/**
 * Class stripTagsTest
 * @package res\infrastructure\StringUtils
 * @covers \vsc\infrastructure\StringUtils::stripTags()
 */
class stripTagsTest extends \BaseUnitTest {

	public function testBasicStripTags() {
		$test =<<<START
<div>Lorem <span>ipsum</span> dolor <a href="test">sic</a> amet.</div>
START;
;
		$this->assertEquals(strip_tags($test), StringUtils::stripTags($test));
		$this->assertEquals('Lorem ipsum dolor sic amet.', StringUtils::stripTags($test));
	}
}
