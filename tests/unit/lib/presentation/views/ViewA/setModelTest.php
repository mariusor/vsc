<?php
namespace tests\lib\presentation\views\ViewA;
use vsc\domain\models\EmptyModel;
use vsc\presentation\views\ViewA;

/**
 * @covers \vsc\presentation\views\ViewA::setModel()
 */
class setModel extends \BaseUnitTest
{
	public function testBasicSetModel()
	{
		$o = new ViewA_underTest_setModel();

		$oModel = new EmptyModel();
		$o->setModel($oModel);

		$this->assertSame($oModel, $o->getModel());
	}
}

class ViewA_underTest_setModel extends ViewA {
	/**
	 * appends values to template variables
	 *
	 * @param array|string $tplVar the template variable name(s)
	 * @param mixed $value the value to append
	 */
	function append($tplVar, $value = null, $merge = false)
	{
		// TODO: Implement append() method.
	}

	/**
	 * assigns values to template variables
	 *
	 * @param array|string $tplVar the template variable name(s)
	 * @param mixed $value the value to assign
	 */
	function assign($tplVar, $value = null)
	{
		// TODO: Implement assign() method.
	}

	/**
	 * executes & displays the template results
	 *
	 * @param string $resourceName
	 */
	function display($resourceName)
	{
		// TODO: Implement display() method.
	}
}
