<?php
namespace tests\res\infrastructure\vsc;
use vsc\infrastructure\vsc;

/**
 * @covers \vsc\infrastructure\vsc::_isCli()
 */
class _isCli extends \BaseUnitTest
{
	public function testIsCli () {
		$this->assertTrue(vsc::isCli());
	}

	public function testNotIsCli () {
		$env = new vsc_underTest__isCli();
		vsc::setInstance($env);

		$this->assertFalse(vsc::isCli());
	}
}

class vsc_underTest__isCli extends vsc {
	private $isCli = false;

	public function setIsCli ($IsIt) {
		$this->isCli = $IsIt;
	}

	protected function _isCli () {
		return $this->isCli;
	}
}
