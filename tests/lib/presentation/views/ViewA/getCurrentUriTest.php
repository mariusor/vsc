<?php
namespace tests\lib\presentation\views\ViewA;
use vsc\presentation\views\ViewA;
use vsc\presentation\requests\RwHttpRequest;
use vsc\infrastructure\vsc;

/**
 * @covers \vsc\presentation\views\ViewA::getCurrentUri()
 */
class getCurrentUri extends \PHPUnit_Framework_TestCase
{
	public function testMockedAtInitialization()
	{
		$o = new ViewA_underTest_getCurrentUri();

		$this->assertEquals($_SERVER['REQUEST_URI'], $o->getCurrentUri());
	}
}

class ViewA_underTest_getCurrentUri extends ViewA {
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
