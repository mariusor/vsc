<?php
namespace tests\lib\application\processors\ProcessorA;
use vsc\application\processors\ProcessorA;
use vsc\domain\models\ModelA;
use vsc\presentation\requests\HttpRequestA;

/**
 * @covers \vsc\application\processors\ProcessorA::setVar()
 */
class setVar extends \PHPUnit_Framework_TestCase
{
	public function testBasicSetVar()
	{
		$o = new ProcessorA_underTest_setVar();

		$sKey = 'test';
		$sVal = uniqid('test:');
		$this->assertTrue($o->setVar($sKey, $sVal));

		$oMirror = new \ReflectionObject($o);
		$oProperty = $oMirror->getProperty('aLocalVars');
		$oProperty->setAccessible(true);
		$randVal = $oProperty->getValue($o);

		$this->assertEquals($randVal[$sKey], $o->getVar($sKey));
		$this->assertEquals($sVal, $o->getVar($sKey));
	}

	public function testSetVarWhenItDoesNotExist()
	{
		$o = new ProcessorA_underTest_setVar();

		$sKey = 'inexistent';
		$sVal = uniqid('test:');
		$this->assertFalse($o->setVar($sKey, $sVal));
	}
}

class ProcessorA_underTest_setVar extends ProcessorA {
	protected $aLocalVars = array('test' => null);
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
