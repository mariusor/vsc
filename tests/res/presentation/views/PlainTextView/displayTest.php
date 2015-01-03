<?php
namespace tests\res\presentation\views\PlainTextView;

/**
 * @covers \vsc\presentation\views\PlainTextView::display()
 */
class display extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$this->markTestIncomplete(" ... ");
	}
}
