<?php
namespace tests\res\application\sitemaps\ErrorMap;
use vsc\application\sitemaps\ErrorMap;
use vsc\application\processors\ErrorProcessor;

/**
 * @covers \vsc\application\sitemaps\ErrorMap::__construct()
 */
class __construct extends \PHPUnit_Framework_TestCase
{
	public function testBasic__construct()
	{
		$o = new ErrorMap();
		$this->assertEquals('\A.*\Z', $o->getRegex());
		$this->assertEquals(ErrorProcessor::class, $o->getPath());

	}
}
