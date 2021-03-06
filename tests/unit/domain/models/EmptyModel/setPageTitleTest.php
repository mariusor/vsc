<?php
namespace tests\domain\models\EmptyModel;
use vsc\domain\models\EmptyModel;

/**
 * @covers \vsc\domain\models\EmptyModel::setPageTitle()
 */
class setPageTitle extends \BaseUnitTest
{
	/**
	 * @covers \vsc\domain\models\EmptyModel::setPageTitle
	 */
	public function testBasicSetPageTitle()
	{
		$o = new EmptyModel();
		$sTitle = 'test title';
		$o->setPageTitle($sTitle);

		$this->assertEquals($sTitle, $o->getPageTitle());
	}
}
