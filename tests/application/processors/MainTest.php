<?php
use avangate\application\processors\Main;
use fixtures\application\processors\FixtureMainProcessor;
use vsc\application\sitemaps\ClassMap;

class MainTest extends PHPUnit_Framework_TestCase {
	/**
	 * @var  Main
	 */
	public $state;

	public function setUp() {
		$this->state = new FixtureMainProcessor();

		$oMap = new ClassMap('\\avangate\\application\\processors\\Main', '.*');
		$this->state->setMap($oMap);
	}
	public function tearDown() {}

	public function testConstruct () {
		$this->assertInstanceOf('\\fixtures\\application\\processors\\FixtureMainProcessor', $this->state);
		$this->assertInstanceOf('\\avangate\\application\\processors\\Main', $this->state);
	}
}
 