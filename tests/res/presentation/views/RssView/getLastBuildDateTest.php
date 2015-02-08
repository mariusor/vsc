<?php
namespace tests\res\presentation\views\RssView;
use vsc\presentation\views\RssView;

/**
 * @covers \vsc\presentation\views\RssView::getLastBuildDate()
 */
class getLastBuildDate extends \PHPUnit_Framework_TestCase
{
	public function testUseless()
	{
		$o = new RssView();
		$this->assertEquals('',$o->getLastBuildDate());
	}
}
