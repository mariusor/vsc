<?php
namespace tests\res\presentation\views\PlainTextView;
use vsc\presentation\views\PlainTextView;

/**
 * @covers \vsc\presentation\views\PlainTextView::display()
 */
class display extends \PHPUnit_Framework_TestCase
{
	public function testUseless()
	{
		$o = new PlainTextView();
		$this->assertEmpty($o->display(''));
	}
}
