<?php
namespace tests\domain\models\StaticFileModel;
use vsc\domain\models\StaticFileModel;

/**
 * @covers \vsc\domain\models\StaticFileModel::getFileName()
 */
class getFileName extends \BaseUnitTest
{
	public function testGetFileNameMatchesAfterSet()
	{
		$o = new StaticFileModel();
		$o->setFilePath(__FILE__);
		$this->assertEquals(basename(__FILE__), $o->getFileName());
	}
}
