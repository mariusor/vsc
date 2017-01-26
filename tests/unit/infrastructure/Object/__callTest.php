<?php
namespace tests\infrastructure\Object;
use vsc\infrastructure\Base;
use vsc\infrastructure\Object;
use vsc\infrastructure\vsc;
use vsc\ExceptionUnimplemented;
use vsc\Exception;

/**
 * @covers \vsc\infrastructure\Object::__call()
 */
class __call extends \BaseUnitTest
{
	/**
	 * @test Object::__call()
	 */
	public function test__callDev() {
		$null = new Object_underTest___call();

		$env = new vsc_underTest___call();
		$env->setIsDevelopment(true);

		vsc::setInstance($env);

		try {
			$null->__call ( uniqid('test'), array());
		} catch (Exception $e) {
			$this->assertInstanceOf(ExceptionUnimplemented::class, $e);
			$this->assertInstanceOf(Exception::class, $e);
		}
		try {
			$null->test();
		} catch (\Exception $e) {
			$this->assertInstanceOf(ExceptionUnimplemented::class, $e);
			$this->assertInstanceOf(Exception::class, $e);
		}
	}

	/**
	 * @test Object::__call()
	 */
	public function test__callNotDev () {
		$null = new Object_underTest___call();

		$env = new vsc_underTest___call();
		$env->setIsDevelopment(false);

		vsc::setInstance($env);

		$this->assertInstanceOf(Base::class, $null->__call ( uniqid('test'), array()));
		$this->assertInstanceOf(Base::class, $null->test());
	}
}

class Object_underTest___call extends Object {}

class vsc_underTest___call extends vsc {
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
