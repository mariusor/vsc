<?php
namespace tests\res\domain\models\ErrorModel;

/**
 * @covers the public method ErrorModel::getMessage()
 */
class getMessage extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$this->markTestIncomplete(" ... ");
	}
}
