<?php
namespace tests\lib\application\sitemaps\ControllerMapT;
use vsc\application\sitemaps\MappingA;
use vsc\application\sitemaps\ControllerMapT;
use vsc\presentation\views\ViewA;

/**
 * @covers \vsc\application\sitemaps\ControllerMapT::getViewPath()
 */
class getViewPath extends \PHPUnit_Framework_TestCase
{
	public function testGetDefaultViewPath()
	{
		$o = new ControllerMapT_underTest_getViewPath(__FILE__, '.*');
		$this->assertEquals('', $o->getViewPath());
	}

	public function testGetSetViewStringPath()
	{
		$o = new ControllerMapT_underTest_getViewPath(__FILE__, '.*');

		$sValue = VSC_FIXTURE_PATH . 'templates/main.tpl.php';
		$o->setView($sValue);
		$this->assertEquals($sValue, $o->getViewPath());
	}

	public function testGetSetViewPath()
	{
		$o = new ControllerMapT_underTest_getViewPath(__FILE__, '.*');

		$oView = new ViewA_underTest_getViewPath();
		$o->setView($oView);
		$this->assertEquals(ViewA_underTest_getViewPath::class, $o->getViewPath());
	}
}

class ViewA_underTest_getViewPath extends ViewA {
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

class ControllerMapT_underTest_getViewPath extends MappingA {
	use ControllerMapT;
}
