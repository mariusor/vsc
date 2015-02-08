<?php
namespace tests\res\presentation\views\RssView;
use vsc\presentation\views\RssView;

/**
 * @covers \vsc\presentation\views\RssView::display()
 */
class display extends \PHPUnit_Framework_TestCase
{
	public function testEmptyAtInitialization()
	{
		$o = new RssView();
		$this->assertEmpty($o->display('test'));
	}
}
