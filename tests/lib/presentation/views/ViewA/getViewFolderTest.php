<?php
namespace tests\lib\presentation\views\ViewA;
use fixtures\presentation\views\testView;

/**
 * @covers \vsc\presentation\views\ViewA::getViewFolder()
 */
class getViewFolder extends \PHPUnit_Framework_TestCase
{
	public function testGetViewFolderEmpty()
	{
		$o = new testView();

		$this->assertEmpty($o->getViewFolder());
	}

	public function testGetViewFolder()
	{
		$o = new testView();

		$t = 'test';
		$o->setFolder($t);
		$this->assertEquals($t, $o->getViewFolder());
	}
}
