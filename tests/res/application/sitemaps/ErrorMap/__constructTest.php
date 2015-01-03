<?php
namespace tests\res\application\sitemaps\ErrorMap;

/**
 * @covers \vsc\application\sitemaps\ErrorMap::__construct()
 */
class __construct extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$this->markTestIncomplete(" ... ");
	}
}
