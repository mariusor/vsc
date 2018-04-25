<?php
namespace tests\infrastructure\Object;
use vsc\infrastructure\BaseObject;
use vsc\infrastructure\vsc;
use vsc\infrastructure\Base;
use vsc\ExceptionUnimplemented;
use vsc\Exception;

/**
 * @covers \vsc\infrastructure\BaseObject::__get()
 */
class __get extends \BaseUnitTest
{
	public function test__getDev () {
		$null = new Base_Object_underTest___get();

		$env = new vsc_underTest___get();
		$env->setIsDevelopment(true);

		vsc::setInstance($env);

		try {
			$test = $null->__get ( uniqid('test'));
			$this->assertNull($test);
		} catch (\Exception $e) {
			$this->assertInstanceOf(ExceptionUnimplemented::class, $e);
			$this->assertInstanceOf(Exception::class, $e);
		}
		try {
			$test = $null->test;
			$this->assertNull($test);
		} catch (\Exception $e) {
			$this->assertInstanceOf(ExceptionUnimplemented::class, $e);
			$this->assertInstanceOf(Exception::class, $e);
		}
	}

	public function test__getNotDev () {
		$null = new Base_Object_underTest___get();

		$env = new vsc_underTest___get();
		$env->setIsDevelopment(false);

		vsc::setInstance($env);

		$this->assertInstanceOf(Base::class, $null->__get( uniqid('test')));
		$this->assertInstanceOf(Base::class, $null->test);
	}
}

class Base_Object_underTest___get extends BaseObject {}

class vsc_underTest___get extends vsc {
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
