<?php
use \vsc\infrastructure\vsc;
use \fixtures\infrastructure\FixtureEnv;

class functionsTest extends \PHPUnit_Framework_TestCase {

	private $state;

	public function setUp () {
		$this->state = get_include_path();
	}

	public function tearDown() {
		set_include_path($this->state);
		vsc::setInstance(new vsc());
	}

	public function testIsDebug () {
		$this->assertTrue (\vsc\isDebug());
	}

	/**
	 * @test
	 */
	public function getErrorHeaderOutputCliWithoutException () {
		$s = \vsc\getErrorHeaderOutput();

		$this->assertEmpty($s);
		$this->assertEquals('', $s);
	}

	/**
	 * @test
	 */
	public function getErrorHeaderOutputNotCliWithoutException () {
		$f = new FixtureEnv();
		$f->setIsCli(false);
		vsc::setInstance($f);
		$s = \vsc\getErrorHeaderOutput();

		$output =<<<START
<?xml version="1.0" encoding="utf-8"?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en"><head><style>ul {padding:0; font-size:0.8em} li {padding:0.2em;display:inline} address {position:fixed;bottom:0;}</style><title>Internal Error</title></head><body><strong>Internal Error</strong><address>&copy; VSC</address><ul><li><a href="#" onclick="p = document.getElementById('trace'); if (p.style.display=='block') p.style.display='none';else p.style.display='block'; return false">toggle trace</a></li></ul><pre style="position:fixed;bottom:2em;display:none;font-size:.8em" id="trace">
START;

		$this->assertEquals($output, $s);
	}


	/**
	 * @test
	 */
	public function getErrorHeaderOutputCliWithException () {
		$e = new \vsc\Exception('test');
		$s = \vsc\getErrorHeaderOutput($e);

		$this->assertEmpty($s);
		$this->assertEquals('', $s);
	}

	/**
	 * @test
	 */
	public function getErrorHeaderOutputNotCliWitException () {
		$e = new \vsc\Exception('test');
		$lineNumber = __LINE__ - 1; // the line above

		$f = new FixtureEnv();
		$f->setIsCli(false);
		vsc::setInstance($f);
		$s = \vsc\getErrorHeaderOutput($e);

		$currentPath = __FILE__;
		$output =<<<START
<?xml version="1.0" encoding="utf-8"?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en"><head><style>ul {padding:0; font-size:0.8em} li {padding:0.2em;display:inline} address {position:fixed;bottom:0;}</style><title>Internal Error: test...</title></head><body><strong>Internal Error: test</strong><address>&copy; VSC</address><ul><li><a href="#" onclick="p = document.getElementById('trace'); if (p.style.display=='block') p.style.display='none';else p.style.display='block'; return false">toggle trace</a></li></ul><p style="font-size:.8em">Triggered in <strong>{$currentPath}</strong> at line {$lineNumber}</p><pre style="position:fixed;bottom:2em;display:none;font-size:.8em" id="trace">
START;

		$this->assertEquals($output, $s);
	}


}
