<?php
namespace tests\application\controllers\FrontControllerA;
use mocks\presentation\views\NullView;
use vsc\application\controllers\ExceptionController;
use vsc\application\controllers\FrontControllerA;

/**
 * @covers \vsc\application\controllers\FrontControllerA::setTemplatePath()
 */
class setTemplatePath extends \BaseUnitTest
{
	public function testBasicSetTemplatePathWithValidFolder()
	{
		$state = new FrontController_underTest_setTemplatePath();

		try {
			$status = $state->setTemplatePath ( VSC_MOCK_PATH . 'templates' );
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
