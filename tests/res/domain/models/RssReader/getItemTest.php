<?php
namespace tests\res\domain\models\RssReader;
use vsc\domain\models\RssReader;
use vsc\infrastructure\Null;

/**
 * @covers \vsc\domain\models\RssReader::getItem()
 */
class getItem extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$o = new RssReader();
		$this->assertInstanceOf(Null::class, $o->getItem(0));
	}
}
