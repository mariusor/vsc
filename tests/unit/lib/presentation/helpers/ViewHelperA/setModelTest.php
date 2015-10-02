<?php
namespace tests\lib\presentation\helpers\ViewHelperA;
use vsc\presentation\helpers\ViewHelperA;
use vsc\domain\models\EmptyModel;

/**
 * @covers \vsc\presentation\helpers\ViewHelperA::setModel()
 */
class setModel extends \PHPUnit_Framework_TestCase
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