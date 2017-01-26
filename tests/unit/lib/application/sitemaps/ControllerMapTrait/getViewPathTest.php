<?php
namespace tests\lib\application\sitemaps\ControllerMapTrait;
use mocks\application\sitemaps\MapFixture;
use vsc\application\sitemaps\MappingA;
use vsc\application\sitemaps\ControllerMapTrait;
use vsc\application\sitemaps\ModuleMapTrait;
use vsc\presentation\views\ViewA;

/**
 * @covers \vsc\application\sitemaps\ControllerMapTrait::getViewPath()
 */
class getViewPath extends \BaseUnitTest
{
	public function testGetDefaultViewPath()
	{
		$o = new ControllerMapT_underTest_getViewPath(__FILE__, '.*');
		$this->assertEquals('', $o->getViewPath());
	}

	public function testGetSetViewStringPath()
	{
		$o = new ControllerMapT_underTest_getViewPath(__FILE__, '.*');

		$sValue = VSC_MOCK_PATH . 'templates/main.tpl.php';
		try {
			$o->setView($sValue);
		} catch (\Exception $e) {

		}
	}

	public function testGetSetViewClassName()
	{
		$o = new ControllerMapT_underTest_getViewPath(__FILE__, '.*');
		$o->setView(ViewA_underTest_getViewPath::class);
		$this->assertEquals(ViewA_underTest_getViewPath::class, $o->getViewPath());
	}

	public function testGetSetViewObject()
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

class ControllerMapT_underTest_getViewPath extends MapFixture {
	use ControllerMapTrait;
	use ModuleMapTrait;
}
