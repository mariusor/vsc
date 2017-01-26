<?php
namespace tests\domain\models\EmptyModel;
use vsc\domain\models\EmptyModel;

/**
 * @covers \vsc\domain\models\EmptyModel::setPageContent()
 */
class setPageContent extends \BaseUnitTest
{
	/**
	 * @covers \vsc\domain\models\EmptyModel::setPageContent
	 */
	public function testBasicSetPageContent()
	{
		$o = new EmptyModel();
		$sContent = 'test content <p>some shit</p>';
		$o->setPageContent($sContent);

		$this->assertEquals($sContent, $o->getPageContent());
	}
}
