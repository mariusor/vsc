<?php
namespace tests\presentation\views\ViewA;
use vsc\Exception;
use vsc\presentation\views\ExceptionView;
use vsc\presentation\views\ViewA;

/**
 * @covers \vsc\presentation\views\ViewA::__call()
 */
class __call extends \BaseUnitTest
{
	public function test__callWithoutModel()
	{
		$o = new ViewA_underTest___call();
		try {
			$this->assertNull($o->__call('test'));
		} catch (\Exception $e) {
			$this->assertInstanceOf(Exception::class, $e);
			$this->assertInstanceOf(ExceptionView::class, $e);
			$this->assertNotEmpty($e->getMessage());
		}
	}
}

class ViewA_underTest___call extends ViewA {
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
