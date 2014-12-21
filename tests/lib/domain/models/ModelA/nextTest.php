<?php
namespace tests\lib\domain\models\ModelA;

/**
 * @covers the public method ModelA::next()
 */
class next extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$this->markTestIncomplete(" ... ");
	}
}
