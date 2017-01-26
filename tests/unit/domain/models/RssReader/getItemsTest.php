<?php
namespace tests\domain\models\RssReader;
use vsc\domain\models\RssReader;

/**
 * @covers \vsc\domain\models\RssReader::getItems()
 */
class getItems extends \BaseUnitTest
{
	public function testEmptyAtInitialization()
	{
		$o = new RssReader();
		$this->assertEmpty($o->getItems());
	}
}
