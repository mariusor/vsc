<?php
namespace tests\lib\presentation\responses\ResponseA;
use vsc\presentation\responses\ResponseA;
use vsc\infrastructure\Base;
use vsc\presentation\views\ViewA;

/**
 * @covers \vsc\presentation\responses\ResponseA::getView()
 */
class getView extends \BaseUnitTest
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
	 * @param array|string $tplVar the template variable name(s)
	 * @param mixed $value the value to append
	 * @param bool $merge
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
