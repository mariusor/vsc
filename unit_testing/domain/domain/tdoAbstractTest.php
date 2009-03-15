<?php
class tdoAbstractTest extends UnitTestCase {
	public function testWorkingFalseAssertion () {
		$this->assertFalse(false, 'To be or not to be false');
	}
}