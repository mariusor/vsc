<?php
namespace tests\lib\application\controllers\FrontControllerA;
use fixtures\presentation\views\NullView;
use vsc\application\controllers\ExceptionController;
use vsc\application\controllers\FrontControllerA;
use vsc\application\sitemaps\ControllerMap;
use fixtures\presentation\views\testView;

/**
 * @covers the public method FrontControllerA::setTemplatePath()
 */
class setTemplatePath extends \PHPUnit_Framework_TestCase
{
	public function testBasicSetTemplatePathWithValidFolder()
	{
		$state = new FrontController_underTest_setTemplatePath();

		try {
			$status = $state->setTemplatePath ( VSC_FIXTURE_PATH . 'templates' );
		} catch (ExceptionController $f) {
			$this->fail ($f->getMessage());
		}
		$this->assertTrue($status);

	}

	public function testBasicSetTemplatePathWithInvalidFolder()
	{
		$state = new FrontController_underTest_setTemplatePath();

		$invalid = uniqid();
		try {
			// will fail
			$state->setTemplatePath ( $invalid );
		} catch (\Exception $f) {
			$this->assertInstanceOf(ExceptionController::class, $f);
		}
	}
}

class FrontController_underTest_setTemplatePath extends FrontControllerA {
	public function getDefaultView () {
		return new NullView();
	}
}
