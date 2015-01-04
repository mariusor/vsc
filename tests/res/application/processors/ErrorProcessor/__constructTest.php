<?php
namespace tests\res\application\processors\ErrorProcessor;
use vsc\application\processors\ErrorProcessor;
use vsc\application\sitemaps\ErrorMap;
use vsc\Exception;

/**
 * @covers \vsc\application\processors\ErrorProcessor::__construct()
 */
class __construct extends \PHPUnit_Framework_TestCase
{
	public function testBasic__construct()
	{
		$e = new Exception('test');
		$o = new ErrorProcessor($e);

		$this->assertInstanceOf(\Exception::class, $o->getModel()->getException());
		$this->assertInstanceOf(ErrorMap::class, $o->getMap());
		$this->assertEquals ('templates', basename($o->getMap()->getTemplatePath()));
		$this->assertEquals ('error.tpl.php', $o->getMap()->getTemplate());
	}
}
