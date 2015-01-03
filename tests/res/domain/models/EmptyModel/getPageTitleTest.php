<?php
namespace tests\res\domain\models\EmptyModel;
use vsc\domain\models\EmptyModel;

/**
 * @covers the public method EmptyModel::getPageTitle()
 */
class getPageTitle extends \PHPUnit_Framework_TestCase
{
	/**
	 * @covers \vsc\domain\models\EmptyModel::getPageTitle
	 */
	public function testBasicGetPageTitle()
	{
		$o = new EmptyModel();
		$sTitle = 'test title';
		$o->setPageTitle($sTitle);

		$this->assertEquals($sTitle, $o->getPageTitle());
	}
}
