<?php
namespace tests\presentation\helpers\ViewHelperA;
use vsc\presentation\helpers\ViewHelperA;
use vsc\domain\models\EmptyModel;

/**
 * @covers \vsc\presentation\helpers\ViewHelperA::setModel()
 */
class setModel extends \BaseUnitTest
{
	public function testBasicSetModel()
	{
		$o = new ViewHelperA_underTest_setModel();

		$oTestModel = new EmptyModel();
		$o->setModel($oTestModel);
		$oModel = $o->getModel();

		$this->assertSame($oTestModel, $oModel);
	}
}

class ViewHelperA_underTest_setModel extends ViewHelperA {}
