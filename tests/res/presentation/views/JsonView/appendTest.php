<?php
namespace tests\res\presentation\views\JsonView;
use vsc\presentation\views\JsonView;

/**
 * @covers \vsc\presentation\views\JsonView::append()
 */
class append extends \PHPUnit_Framework_TestCase
{
	public function testUseless()
	{
		$o = new JsonView();
		$this->assertNull($o->append(''));
	}
}
