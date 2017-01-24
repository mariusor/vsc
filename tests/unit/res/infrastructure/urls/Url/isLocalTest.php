<?php
namespace tests\res\infrastructure\urls\Url;
use vsc\infrastructure\urls\Url;


/**
 * @covers \vsc\infrastructure\urls\Url::isLocal()
 */
class isLocalTest extends \BaseUnitTest {
	public function testIsLocal() {
		$oUrl = new Url();
		$oUrl->setPath(__FILE__);
		$this->assertTrue($oUrl->isLocal());
	}

	public function testIsRemote() {
		$oUrl = new Url();
		$oUrl->setHost('google.com');
		$this->assertFalse($oUrl->isLocal());
	}

	public function testIsRemoteIP() {
		$oUrl = new Url();
		$oUrl->setHost('8.8.8.8');
		$this->assertFalse($oUrl->isLocal());
	}
}
