<?php
namespace tests\application\sitemaps\ErrorMap;
use vsc\application\sitemaps\ErrorProcessorMap;
use vsc\application\processors\ErrorProcessor;

/**
 * @covers \vsc\application\sitemaps\ErrorProcessorMap::__construct()
 */
class __construct extends \BaseUnitTest
{
	public function testBasic__construct()
	{
		$o = new ErrorProcessorMap();
		$this->assertEquals('\A.*\Z', $o->getRegex());
		$this->assertEquals(ErrorProcessor::class, $o->getPath());

	}
}
