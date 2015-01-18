<?php
namespace tests\lib\presentation\views\ViewA;
use vsc\presentation\views\ViewA;
use vsc\application\sitemaps\ProcessorMap;

/**
 * @covers \vsc\presentation\views\ViewA::getTemplatePath()
 */
class getTemplatePath extends \PHPUnit_Framework_TestCase
{
	public function testDefaultValueAtInitialization()
	{
		$o = new ViewA_underTest_getTemplatePath();

		$oMap = new ProcessorMap('', '');
		$o->setMap($oMap);

		$genericTemplatePath = VSC_RES_PATH . 'templates' . DIRECTORY_SEPARATOR;

		$this->assertEquals($genericTemplatePath, $o->getTemplatePath());
	}
}

class ViewA_underTest_getTemplatePath extends ViewA {
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
