<?php
namespace tests\lib\application\processors\ProcessorA;
use vsc\application\processors\ProcessorA;
use vsc\domain\models\ModelA;
use vsc\presentation\requests\HttpRequestA;

/**
 * @covers the public method ProcessorA::getVar()
 */
class getVar extends \PHPUnit_Framework_TestCase
{
	public function testBasicGetVar () {
		$o = new ProcessorA_underTest_getVar();

		$oMirror = new \ReflectionObject($o);
		$oProperty = $oMirror->getProperty('aLocalVars');
		$oProperty->setAccessible(true);
		$randVal = $oProperty->getValue($o);

		$this->assertEquals($randVal['test'], $o->getVar('test'));
	}
}

class ProcessorA_underTest_getVar extends ProcessorA {
	public function __construct() {
		$this->aLocalVars['test'] = uniqid();
	}
	/**
	 * @return void
	 */
	public function init()
	{
		// TODO: Implement init() method.
	}

	/**
	 * Returns a data model, which can be used in the view
	 * @param HttpRequestA $oHttpRequest
	 * @returns ModelA
	 */
	public function handleRequest(HttpRequestA $oHttpRequest)
	{
		// TODO: Implement handleRequest() method.
	}
}
