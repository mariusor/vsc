<?php
namespace tests\lib\presentation\views\ViewA;
use vsc\presentation\views\ViewA;
use vsc\presentation\helpers\ViewHelperA;
use vsc\application\sitemaps\ProcessorMap;

/**
 * @covers \vsc\presentation\views\ViewA::registerHelper()
 */
class registerHelper extends \PHPUnit_Framework_TestCase
{
	public function testBasicRegisterHelper()
	{
		$o = new ViewA_underTest_registerHelper();

		$oMap = new ProcessorMap('', '');
		$o->setMap($oMap);

		$oHelper = new ViewHelperA_underTest_registerHelper();
		$o->registerHelper($oHelper);

		$helpers = $o->getMap()->getViewHelpers();
		$this->assertEquals(1, count($helpers));
		$this->assertSame($oHelper, $helpers[0]);
	}
}

class ViewHelperA_underTest_registerHelper extends ViewHelperA {}

class ViewA_underTest_registerHelper extends ViewA {
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
