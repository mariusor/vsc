<?php
namespace tests\res\domain\models\RssReader;
use vsc\domain\models\RssReader;
use vsc\domain\domain\RssItem;

/**
 * @covers \vsc\domain\models\RssReader::addItem()
 */
class addItem extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$s = new RssItem();
		$o = new RssReader();
		$o->addItem($s);

		$this->assertContains($s, $o->getItems());
		$this->assertEquals($s, $o->getItem(0));
	}
}
