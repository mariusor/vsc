<?php
namespace tests\res\domain\models\ErrorModel;

/**
 * @covers \vsc\domain\models\ErrorModel::getMessage()
 */
class getMessage extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$this->markTestIncomplete(" ... ");
	}
}
