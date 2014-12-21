<?php
namespace tests\res\application\dispatchers\RwDispatcher;

/**
 * @covers the public method RwDispatcher::getProcessController()
 */
class getProcessController extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$this->markTestIncomplete(" ... ");
	}
}
