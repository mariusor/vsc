<?php
namespace tests\res\application\sitemaps\ErrorControllerMap;
use vsc\application\sitemaps\ErrorControllerMap;
use vsc\application\controllers\Html5Controller;

/**
 * @covers \vsc\application\sitemaps\ErrorControllerMap::__construct()
 */
class __construct extends \PHPUnit_Framework_TestCase
{
	public function testBasic__construct()
	{
		$o = new ErrorControllerMap();
		$this->assertEquals('\A.*\Z', $o->getRegex());
		$this->assertEquals(Html5Controller::class, $o->getPath());

	}
}
