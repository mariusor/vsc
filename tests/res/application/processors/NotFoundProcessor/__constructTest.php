<?php
namespace tests\res\application\processors\NotFoundProcessor;

/**
 * @covers the public method NotFoundProcessor::__construct()
 */
class __construct extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$this->markTestIncomplete(" ... ");
	}
}
