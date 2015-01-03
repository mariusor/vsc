<?php
/**
 * Created by PhpStorm.
 * User: habarnam
 * Date: 1/4/15
 * Time: 12:06 AM
 */

namespace res\functions_inc;


class isDebugTest extends \PHPUnit_Framework_TestCase {

	public function testIsDebug () {
		$this->assertTrue (\vsc\isDebug());
	}
}
