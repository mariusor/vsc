<?php
namespace tests\res\presentation\views\XmlView;
use vsc\presentation\views\XmlView;

/**
 * @covers \vsc\presentation\views\XmlView::getMetaHeaders()
 */
class getMetaHeaders extends \BaseUnitTest
{
	public function testEmptyAtInitialization()
	{
		$o = new XmlView();
		$this->assertEquals([], $o->getMetaHeaders());
	}
}
