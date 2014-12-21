<?php
namespace tests\res\domain\models\ErrorModel;

/**
 * @covers the public method ErrorModel::getException()
 */
class getException extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$this->markTestIncomplete(" ... ");
	}
}
