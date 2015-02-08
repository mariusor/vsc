<?php
namespace tests\res\presentation\views\JsonView;
use vsc\presentation\views\JsonView;

/**
 * @covers \vsc\presentation\views\JsonView::outputModel()
 */
class outputModel extends \PHPUnit_Framework_TestCase
{
	public function testOutputModelWithEmptyArray()
	{
		$o = new JsonView();
		$this->assertEquals(json_encode([]), $o->outputModel([]));
	}
}
