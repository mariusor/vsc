<?php
namespace tests\lib\presentation\responses\ResponseA;
use vsc\presentation\responses\ResponseA;
use vsc\infrastructure\Base;
use vsc\presentation\views\ViewA;

/**
 * @covers \vsc\presentation\responses\ResponseA::getView()
 */
class getView extends \PHPUnit_Framework_TestCase
{
	public function testEmptyAtInitialization()
	{
		$o = new ResponseA_underTest_getView();
		$this->assertInstanceOf(Base::class, $o->getView());
	}

	public function testBasicGetView ()
	{
		$o = new ResponseA_underTest_getView();

		$o->setView(new ViewA_underTest_getView());
		$this->assertInstanceOf(ViewA::class, $o->getView());
		$this->assertInstanceOf(ViewA_underTest_getView::class, $o->getView());
	}
}

class ResponseA_underTest_getView extends ResponseA {}

class ViewA_underTest_getView extends ViewA {
	/**
	 * appends values to template variables
	 *
	 * @param array|string $tpl_var the template variable name(s)
	 * @param mixed $value the value to append
	 * @param bool $merge
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
