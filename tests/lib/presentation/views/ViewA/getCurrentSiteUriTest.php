<?php
namespace tests\lib\presentation\views\ViewA;
use vsc\presentation\views\ViewA;

/**
 * @covers \vsc\presentation\views\ViewA::getCurrentSiteUri()
 */
class getCurrentSiteUri extends \PHPUnit_Framework_TestCase
{
	public function testEmptyGetCurrentSiteUri () {
		$this->assertEmpty(ViewA::getCurrentSiteUri());
	}
}
