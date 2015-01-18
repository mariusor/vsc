<?php
namespace tests\lib\presentation\views\ViewA;
use vsc\Exception;
use vsc\presentation\views\ExceptionView;
use vsc\presentation\views\ViewA;

/**
 * @covers \vsc\presentation\views\ViewA::getMap()
 */
class getMap extends \PHPUnit_Framework_TestCase
{
	public function testEmptyAtInitialize()
	{
		$o = new ViewA_underTest_getMap();
		try {
			$this->assertNull($o->getMap());
		} catch (\Exception $e) {
			$this->assertInstanceOf(Exception::class, $e);
			$this->assertInstanceOf(ExceptionView::class, $e);
			$this->assertNotEmpty($e->getMessage());
		}
	}
}

class ViewA_underTest_getMap extends ViewA {
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
