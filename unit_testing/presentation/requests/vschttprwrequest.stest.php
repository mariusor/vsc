<?php
class vscHttpRwRequest extends Snap_UnitTestCase {
	private $state;

	public function setUp () {
		$_GET		= array ('ana' => 'are', 'mere' => '');
		$_POST		= array ('postone' => 'are', 'ana' => '');
		$_SERVER	= array ('SERVER_SOFTWARE' => 'lighttpd', 'PHP_SELF' => '/', 'REQUEST_URI' => '/ana:are/test:123/');

		import ('presentation/requests');
		$this->state = new vscRwHttpRequest();
	}

	public function tearDown () {
		unset ($this->state);
	}

	public function testGetGetVarCorrect() {
		return $this->assertEqual($_GET['ana'], $this->state->getVar('ana'));
	}

	public function testGetGetVarInorrect() {
		$this->willThrow('vscException');
		return $this->assertNull($this->state->getVar('asdf'));
	}

	public function testGetPostVarIncorrect() {
		return $this->assertNotEqual($_POST['ana'], $this->state->getVar('ana'));
	}

	public function testGetPostVarCorrect() {
		return $this->assertEqual($_POST['postone'], $this->state->getVar('postone'));
	}

	public function testGetTaintedVarCorrect() {
		return $this->assertEqual('123', $this->state->getVar('test'));
	}
}
