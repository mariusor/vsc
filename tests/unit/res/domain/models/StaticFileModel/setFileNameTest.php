<?php
namespace tests\res\domain\models\StaticFileModel;
use vsc\domain\models\StaticFileModel;

/**
 * @covers \vsc\domain\models\StaticFileModel::setFileName()
 */
class setFileName extends \PHPUnit_Framework_TestCase
{
	public function testBasicSetFilename()
	{
		$o = new StaticFileModel();
		$o->setFileName(__FILE__);
		$this->assertEquals(__FILE__, $o->getFileName());
	}
}
