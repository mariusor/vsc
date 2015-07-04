<?php
namespace tests\lib\presentation\views\ViewA;
use vsc\presentation\views\ViewA;

/**
 * @covers \vsc\presentation\views\ViewA::getCurrentSiteUri()
 */
class getCurrentSiteUri extends \PHPUnit_Framework_TestCase
{
	public function setUp() {

	}
	public function testGetCurrentSiteUriFromFixture () {
		$this->assertEquals('/test/ana:are/test:123/', ViewA::getCurrentSiteUri());
	}
}
