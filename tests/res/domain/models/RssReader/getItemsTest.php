<?php
namespace tests\res\domain\models\RssReader;
use vsc\domain\models\RssReader;

/**
 * @covers \vsc\domain\models\RssReader::getItems()
 */
class getItems extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$o = new RssReader();
		$this->assertEmpty($o->getItems());
	}
}
