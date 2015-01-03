<?php
namespace tests\res\domain\models\EmptyModel;
use vsc\domain\models\EmptyModel;

/**
 * @covers the public method EmptyModel::getPageContent()
 */
class getPageContent extends \PHPUnit_Framework_TestCase
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
