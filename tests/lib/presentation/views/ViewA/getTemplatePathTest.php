<?php
namespace tests\lib\presentation\views\ViewA;
use vsc\application\sitemaps\ClassMap;
use vsc\presentation\views\ViewA;

/**
 * @covers \vsc\presentation\views\ViewA::getTemplatePath()
 */
class getTemplatePath extends \PHPUnit_Framework_TestCase
{
	public function testDefaultValueAtInitialization()
	{
		$o = new ViewA_underTest_getTemplatePath();

		$oMap = new ClassMap('', '');
		$o->setMap($oMap);

		$this->assertEquals('', $o->getTemplatePath());
	}
}

class ViewA_underTest_getTemplatePath extends ViewA {
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
