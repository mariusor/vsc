<?php
use \vsc\presentation\responses\HttpResponseType;

class HttpResponseTypeTest extends \PHPUnit_Framework_TestCase {
	private $statuses = array ();

	public function setUp() {
		$Mirror = new \ReflectionClass(HttpResponseType::class);
		$MirrorProperty = $Mirror->getProperty('aStatusList');
		$MirrorProperty->setAccessible(ReflectionProperty::IS_PUBLIC);
		$this->statuses = $MirrorProperty->getValue();
	}

	public function tearDown() {}

	public function testIsValidStatus() {
		for ($i = 0; $i < 600; $i++) {
			if (array_key_exists($i, $this->statuses)) {
				$this->assertTrue(HttpResponseType::isValidStatus($i));
			} else {
				$this->assertFalse(HttpResponseType::isValidStatus($i));
			}
		}
	}

	public function testGetStatus() {
		foreach ($this->statuses as $iStatus => $sStatusText) {
			$this->assertEquals($this->statuses[$iStatus], HttpResponseType::getStatus($iStatus));
		}
	}
}
