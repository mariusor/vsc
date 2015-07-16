<?php
namespace tests\lib\presentation\views\ViewA;
use vsc\presentation\views\ViewA;
use vsc\application\sitemaps\ProcessorMap;

/**
 * @covers \vsc\presentation\views\ViewA::setMap()
 */
class setMap extends \PHPUnit_Framework_TestCase
{
	public function testBasicSetMap()
	{
		$o = new ViewA_underTest_setMap();

		$oMap = new ProcessorMap('', '');
		$o->setMap($oMap);

		$this->assertSame($oMap, $o->getMap());
	}
}

class ViewA_underTest_setMap extends ViewA {
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
