<?php
namespace tests\presentation\views\ViewA;
use vsc\presentation\views\ViewA;

/**
 * @covers \vsc\presentation\views\ViewA::__get()
 */
class __get extends \BaseUnitTest
{
	public function test__getInvalidValue()
	{
		$o = new ViewA_underTest___get();
		$this->assertEquals('', $o->__get('test'));
		$this->assertEquals('', $o->__get('rand'));
	}
}

class ViewA_underTest___get extends ViewA {
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
