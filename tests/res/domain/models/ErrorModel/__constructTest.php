<?php
namespace tests\res\domain\models\ErrorModel;

/**
 * @covers \vsc\domain\models\ErrorModel::__construct()
 */
class __construct extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$this->markTestIncomplete(" ... ");
	}
}
