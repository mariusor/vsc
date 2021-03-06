<?php
namespace tests\domain\models\EmptyModel;
use vsc\domain\models\EmptyModel;

/**
 * @covers \vsc\domain\models\EmptyModel::getPageContent()
 */
class getPageContent extends \BaseUnitTest
{
	/**
	 * @covers \vsc\domain\models\EmptyModel::getPageContent
	 */
	public function testBasicGetPageContent()
	{
		$o = new EmptyModel();
		$sContent = 'test content <p>some shit</p>';
		$o->setPageContent($sContent);

		$this->assertEquals($sContent, $o->getPageContent());
	}
}
