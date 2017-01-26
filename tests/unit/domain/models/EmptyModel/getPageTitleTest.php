<?php
namespace tests\domain\models\EmptyModel;
use vsc\domain\models\EmptyModel;

/**
 * @covers \vsc\domain\models\EmptyModel::getPageTitle()
 */
class getPageTitle extends \BaseUnitTest
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
