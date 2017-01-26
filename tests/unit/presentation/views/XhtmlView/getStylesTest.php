<?php
namespace tests\presentation\views\XhtmlView;
use vsc\presentation\views\XhtmlView;

/**
 * @covers \vsc\presentation\views\XhtmlView::getStyles()
 */
class getStyles extends \BaseUnitTest
{
	public function testEmptyAtInitialization()
	{
		$o = new XhtmlView();
		$this->assertEquals([], $o->getStyles());
	}
}
