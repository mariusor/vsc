<?php
namespace tests\res\domain\domain\RssItem;
use vsc\domain\domain\RssItem;

/**
 * @covers \vsc\domain\domain\RssItem::__construct()
 */
class __construct extends \PHPUnit_Framework_TestCase
{
	public function testBasic__construct()
	{
		$o = new RssItem();
		$this->assertEmpty($o->category);
		$this->assertEmpty($o->description);
		$this->assertEmpty($o->guid);
		$this->assertEmpty($o->link);
		$this->assertEmpty($o->pubDate);
		$this->assertEmpty($o->title);
	}
}
