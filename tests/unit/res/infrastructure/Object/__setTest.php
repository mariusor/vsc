<?php
namespace tests\res\infrastructure\Object;
use vsc\infrastructure\Object;
use vsc\infrastructure\vsc;
use vsc\ExceptionUnimplemented;
use vsc\Exception;

/**
 * @covers \vsc\infrastructure\Object::__set()
 */
class __set extends \BaseUnitTest
{

	public function test__setDev () {
		$null = new Object_underTest___set();

		$env = new vsc_underTest___set();
		$env->setIsDevelopment(true);

		vsc::setInstance($env);

		try {
			$null->__set ( uniqid('test'), uniqid('val:'));
		} catch (\Exception $e) {
			$this->assertInstanceOf(ExceptionUnimplemented::class, $e);
			$this->assertInstanceOf(Exception::class, $e);
		}
		try {
			$null->test = uniqid('val:');
		} catch (\Exception $e) {
			$this->assertInstanceOf(ExceptionUnimplemented::class, $e);
			$this->assertInstanceOf(Exception::class, $e);
		}
	}

	public function test__setNotDev () {
		$null = new Object_underTest___set();

		$env = new vsc_underTest___set();
		$env->setIsDevelopment(false);

		vsc::setInstance($env);

		$this->assertNull($null->__set ( uniqid('test'), uniqid('val:')));
	}
}

class Object_underTest___set extends Object {}

class vsc_underTest___set extends vsc {
	private $isDevelopmentEnviroment = false;

	public function setIsDevelopment ($isDevelopment) {
		$this->isDevelopmentEnviroment = $isDevelopment;
	}

	/**
	 * @return boolean
	 */
	public function isDevelopment () {
		return $this->isDevelopmentEnviroment;
	}
}
