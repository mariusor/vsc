<?php
namespace tests\res\domain\models\RssReader;
use vsc\domain\models\RssReader;
use vsc\infrastructure\Base;

/**
 * @covers \vsc\domain\models\RssReader::getItem()
 */
class getItem extends \PHPUnit_Framework_TestCase
{
	public function testGetItemReturnsNullObjectForNoItems()
	{
		$o = new RssReader();
		$this->assertInstanceOf(Base::class, $o->getItem(0));
	}
}
