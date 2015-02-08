<?php
namespace tests\res\domain\models\StaticFileModel;
use vsc\domain\models\StaticFileModel;

/**
 * @covers \vsc\domain\models\StaticFileModel::getFileName()
 */
class getFileName extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$o = new StaticFileModel();
		$o->setFilePath(__FILE__);
		$this->assertEquals(basename(__FILE__), $o->getFileName());
	}
}
