<?php
namespace tests\res\domain\models\EmptyModel;
use vsc\domain\models\EmptyModel;

/**
 * @covers the public method EmptyModel::setPageTitle()
 */
class setPageTitle extends \PHPUnit_Framework_TestCase
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
