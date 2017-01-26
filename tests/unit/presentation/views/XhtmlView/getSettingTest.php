<?php
namespace tests\presentation\views\XhtmlView;
use vsc\presentation\views\XhtmlView;

/**
 * @covers \vsc\presentation\views\XhtmlView::getSetting()
 */
class getSetting extends \BaseUnitTest
{
	public function testEmptyAtInitialization()
	{
		$o = new XhtmlView();
		$this->assertEquals('', $o->getSetting('inexistent'));
	}
}
