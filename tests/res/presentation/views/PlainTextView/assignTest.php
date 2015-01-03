<?php
namespace tests\res\presentation\views\PlainTextView;

/**
 * @covers \vsc\presentation\views\PlainTextView::assign()
 */
class assign extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$this->markTestIncomplete(" ... ");
	}
}
