<?php
namespace tests\domain\models\RssReader;
use vsc\domain\models\RssReader;

/**
 * @covers \vsc\domain\models\RssReader::setItems()
 */
class setItems extends \BaseUnitTest
{
	public function testSetItemsWithEmptySet()
	{
		$a = [];
		$o = new RssReader();
		$o->setItems($a);

		$this->assertEquals($a, $o->getItems());
	}
}
