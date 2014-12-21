<?php
namespace tests\res\presentation\views\PlainTextView;

/**
 * @covers the public method PlainTextView::display()
 */
class display extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$this->markTestIncomplete(" ... ");
	}
}
