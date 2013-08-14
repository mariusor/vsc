<?php
class vscHttpRwRequestTest extends PHPUnit_Framework_TestCase {
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
		return $this->assertEquals($_GET['ana'], $this->state->getVar('ana'));
	}

	public function testGetGetVarInorrect() {
// 		$this->willThrow('vscException');
		return $this->assertEquals($this->state->getVar('asdf'), '');
	}

	public function testGetPostVarIncorrect() {
		return $this->assertNotEquals($_POST['ana'], $this->state->getVar('ana'));
	}

	public function testGetPostVarCorrect() {
		return $this->assertEquals($_POST['postone'], $this->state->getVar('postone'));
	}

	public function testGetTaintedVarCorrect() {
		return $this->assertEquals('123', $this->state->getVar('test'));
	}
}
