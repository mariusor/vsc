<?php
namespace tests\res\application\processors\NotFoundProcessor;

/**
 * @covers \vsc\application\processors\NotFoundProcessor::__construct()
 */
class __construct extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$this->markTestIncomplete(" ... ");
	}
}
