<?php
namespace infrastructure;

use fixtures\infrastructure\FixtureEnv;
use vsc\Exception;
use vsc\ExceptionUnimplemented;
use vsc\infrastructure\Null;
use vsc\infrastructure\vsc;

class NullTest extends \PHPUnit_Framework_TestCase {
	public function test__call () {
		$null = new Null();

		$this->assertInstanceOf(Null::class, $null->__call ( 'getSomething', array()));
		$this->assertInstanceOf(Null::class, $null->getSomething('test'));
	}

	public function test__get () {
		$null = new Null();

		$this->assertInstanceOf(Null::class, $null->__get ('test'));
		$this->assertInstanceOf(Null::class, $null->test);
	}

	public function test__setDev () {
		$null = new Null();

		$env = new FixtureEnv();
		$env->setIsDevelopment(true);

		vsc::setInstance($env);

		try {
			$null->__set ( uniqid('test'), uniqid('val:'));
		} catch (Exception $e) {
			$this->assertInstanceOf(ExceptionUnimplemented::class, $e);
			$this->assertInstanceOf(Exception::class, $e);
		}
		try {
			$null->test = uniqid('val:');
		} catch (Exception $e) {
			$this->assertInstanceOf(ExceptionUnimplemented::class, $e);
			$this->assertInstanceOf(Exception::class, $e);
		}
	}

	public function test__setNotDev () {
		$null = new Null();

		$env = new FixtureEnv();
		$env->setIsDevelopment(false);

		vsc::setInstance($env);

		$this->assertNull($null->__set ( uniqid('test'), uniqid('val:')));
	}
	public function test__toString () {
		$null = new Null();

		$this->assertSame('', (string)$null);
		$this->assertSame('', $null->__toString());
		$this->assertSame('', (string)$null->__get ('test'));
		$this->assertSame('', $null->__get ('test')->__toString());
		$this->assertSame('', (string)$null->test);
		$this->assertSame('', $null->test->__toString());
		$this->assertSame('', (string)$null->__call ( 'getSomething', array()));
		$this->assertSame('', $null->__call ( 'getSomething', array())->__toString());
		$this->assertSame('', (string)$null->getSomething('test'));
		$this->assertSame('', $null->getSomething('test')->__toString());
	}
}
