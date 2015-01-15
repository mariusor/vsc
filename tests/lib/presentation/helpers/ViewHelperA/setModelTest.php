<?php
namespace tests\lib\presentation\helpers\ViewHelperA;
use vsc\presentation\helpers\ViewHelperA;
use vsc\domain\models\EmptyModel;

/**
 * @covers \vsc\presentation\helpers\ViewHelperA::setModel()
 */
class setModel extends \PHPUnit_Framework_TestCase
{
	public function testEmptyAtInitialization()
	{
		$o = new ViewHelperA_underTest_setModel();
		$oModel = new EmptyModel();
		$o->setModel($oModel);
		$this->assertSame($oModel, $o->getModel());
	}
}

class ViewHelperA_underTest_setModel extends ViewHelperA {}

