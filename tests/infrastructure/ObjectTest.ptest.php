<?php
use fixtures\domain\models\ModelFixture;
use vsc\domain\models\ModelA;
use fixtures\application\controllers\FixtureRESTController;
use fixtures\application\controllers\GenericFrontController;
use fixtures\application\processors\ProcessorFixture;
use fixtures\application\processors\RESTProcessorFixture;
use fixtures\infrastructure\FixtureEnv;
use fixtures\infrastructure\ObjectFixture;
use vsc\application\controllers\FrontControllerA;
use vsc\application\processors\ProcessorA;
use vsc\Exception;
use vsc\ExceptionUnimplemented;
use vsc\infrastructure\Null;
use vsc\infrastructure\vsc;
use vsc\infrastructure\Object;
use vsc\rest\application\controllers\RESTController;
use vsc\rest\application\processors\RESTProcessorA;

class ObjectTest extends \PHPUnit_Framework_TestCase {
	/**
	 * @test Object::__call()
	 */
	public function test__callDev() {
		$null = new ObjectFixture();

		$env = new FixtureEnv();
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
		} catch (Exception $e) {
			$this->assertInstanceOf(ExceptionUnimplemented::class, $e);
			$this->assertInstanceOf(Exception::class, $e);
		}
	}

	/**
	 * @test Object::__call()
	 */
	public function test__callNotDev () {
		$null = new ObjectFixture();

		$env = new FixtureEnv();
		$env->setIsDevelopment(false);

		vsc::setInstance($env);

		$this->assertInstanceOf(Null::class, $null->__call ( uniqid('test'), array()));
		$this->assertInstanceOf(Null::class, $null->test());
	}

	public function test__getDev () {
		$null = new ObjectFixture();

		$env = new FixtureEnv();
		$env->setIsDevelopment(true);

		vsc::setInstance($env);

		try {
			$test = $null->__get ( uniqid('test'));
		} catch (Exception $e) {
			$this->assertInstanceOf(ExceptionUnimplemented::class, $e);
			$this->assertInstanceOf(Exception::class, $e);
		}
		try {
			$test = $null->test;
		} catch (Exception $e) {
			$this->assertInstanceOf(ExceptionUnimplemented::class, $e);
			$this->assertInstanceOf(Exception::class, $e);
		}
	}

	public function test__getNotDev () {
		$null = new ObjectFixture();

		$env = new FixtureEnv();
		$env->setIsDevelopment(false);

		vsc::setInstance($env);

		$this->assertInstanceOf(Null::class, $null->__get( uniqid('test')));
		$this->assertInstanceOf(Null::class, $null->test);
	}

	public function test__setDev () {
		$null = new ObjectFixture();

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
		$null = new ObjectFixture();

		$env = new FixtureEnv();
		$env->setIsDevelopment(false);

		vsc::setInstance($env);

		$this->assertNull($null->__set ( uniqid('test'), uniqid('val:')));
	}

	public function test__callStaticDev () {
		$env = new FixtureEnv();
		$env->setIsDevelopment(true);

		vsc::setInstance($env);

		try {
			ObjectFixture::__callStatic('test', array());
		} catch (Exception $e) {
			$this->assertInstanceOf(ExceptionUnimplemented::class, $e);
			$this->assertInstanceOf(Exception::class, $e);
		}
		try {
			ObjectFixture::testCall('test');
		} catch (Exception $e) {
			$this->assertInstanceOf(ExceptionUnimplemented::class, $e);
			$this->assertInstanceOf(Exception::class, $e);
		}
	}

	public function test__callStaticNotDev () {
		$env = new FixtureEnv();
		$env->setIsDevelopment(false);

		vsc::setInstance($env);

		$this->assertInstanceOf(Null::class, ObjectFixture::__callStatic('test', array()));
		$this->assertInstanceOf(Null::class, ObjectFixture::testCall('test'));
	}

	public function testIsValid () {
		$TestVar = new Null();
		$this->assertTrue (Null::isValid($TestVar));
		$this->assertTrue (Object::isValid($TestVar));

		$TestVar = new ObjectFixture();
		$this->assertTrue (ObjectFixture::isValid($TestVar));
		$this->assertTrue (Object::isValid($TestVar));

		$TestVar = new RESTProcessorFixture();
		$this->assertTrue (RESTProcessorFixture::isValid($TestVar));
		$this->assertTrue (RESTProcessorA::isValid($TestVar));
		$this->assertTrue (ProcessorA::isValid($TestVar));
		$this->assertTrue (Object::isValid($TestVar));

		$TestVar = new ProcessorFixture();
		$this->assertTrue (ProcessorA::isValid($TestVar));
		$this->assertTrue (Object::isValid($TestVar));

		$TestVar = new FixtureRESTController();
		$this->assertTrue (FixtureRESTController::isValid($TestVar));
		$this->assertTrue (RESTController::isValid($TestVar));
		$this->assertTrue (FrontControllerA::isValid($TestVar));
		$this->assertTrue (Object::isValid($TestVar));

		$TestVar = new GenericFrontController();
		$this->assertTrue (GenericFrontController::isValid($TestVar));
		$this->assertTrue (FrontControllerA::isValid($TestVar));
		$this->assertTrue (Object::isValid($TestVar));

		$TestVar = new ModelFixture();
		$this->assertTrue (ModelFixture::isValid($TestVar));
		$this->assertTrue (ModelA::isValid($TestVar));
	}
}
