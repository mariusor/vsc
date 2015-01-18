<?php
namespace tests\lib\presentation\views\ViewA;
use vsc\domain\models\EmptyModel;
use vsc\presentation\views\ViewA;

/**
 * @covers \vsc\presentation\views\ViewA::setModel()
 */
class setModel extends \PHPUnit_Framework_TestCase
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
	 * @param array|string $tpl_var the template variable name(s)
	 * @param mixed $value the value to append
	 */
	function append($tpl_var, $value = null, $merge = false)
	{
		// TODO: Implement append() method.
	}

	/**
	 * assigns values to template variables
	 *
	 * @param array|string $tpl_var the template variable name(s)
	 * @param mixed $value the value to assign
	 */
	function assign($tpl_var, $value = null)
	{
		// TODO: Implement assign() method.
	}

	/**
	 * executes & displays the template results
	 *
	 * @param string $resource_name
	 */
	function display($resource_name)
	{
		// TODO: Implement display() method.
	}
}
