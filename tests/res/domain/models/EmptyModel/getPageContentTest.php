<?php
namespace tests\res\domain\models\EmptyModel;

/**
 * @covers the public method EmptyModel::getPageContent()
 */
class getPageContent extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$this->markTestIncomplete(" ... ");
	}
}
