<?php
import (VSC_FIXTURE_PATH);

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2013-08-17 at 11:03:33.
 */
class vscModelATest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var vscModelFixture
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$this->object = new vscModelFixture();
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown()
	{
		$this->object = null;
	}

	/**
	 * @covers vscModelA::setOffset
	 */
	public function testGetSetOffset()
	{
		$sOffset = 'test';
		$this->object->setOffset($sOffset);
		$this->assertEquals($sOffset, $this->object->getOffset());
	}

	/**
	 * @covers vscModelA::offsetSet
	 */
	public function testOffsetSet()
	{
		$sOffset = 'test';
		$sValue = 'asd';
		
		$this->object->offsetSet($sOffset, $sValue);
		$this->assertEquals($sValue, $this->object[$sOffset]);
	}

	/**
	 * @covers vscModelA::offsetExists
	 */
	public function testOffsetExists()
	{
		$sOffset = 'test';
		$this->assertTrue($this->object->offsetExists($sOffset));
	}

	/**
	 * @covers vscModelA::offsetExists
	 */
	public function testOffsetDoesntExist()
	{
		$sOffset = 'nonexistent';
		$this->assertFalse($this->object->offsetExists($sOffset));
	}

	/**
	 * @covers vscModelA::offsetUnset
	 * @todo   Implement testOffsetUnset().
	 */
	public function testOffsetUnset()
	{
		// this method has not yet been implemented correctly
	}

	/**
	 * @covers vscModelA::current
	 */
	public function testCurrentAtInitialization()
	{
		$this->assertEquals($this->object->test, $this->object->current());
	}

	/**
	 * @covers vscModelA::current
	 */
	public function testCurrentAtAttribution()
	{
		$sOffset = 'test';
		$this->object->$sOffset = 'test';
		
		$this->assertEquals($sOffset, $this->object->current());
	}

	/**
	 * @covers vscModelA::current
	 */
	public function testCurrentAtAttributionUsingBraketOperator()
	{
		$sOffset = 'test';
		$this->object[$sOffset] = 'test';
		
		$this->assertEquals($sOffset, $this->object->current());
	}

	/**
	 * @covers vscModelA::key()
	 */
	public function testKeyAtInitialization()
	{
		$oMirror = new ReflectionClass(get_class($this->object));
		$aProperties = $oMirror->getProperties();
		
		$oReflectionKey = array_shift($aProperties);
		
		$this->assertEquals($oReflectionKey->name, $this->object->key());
	}

	/**
	 * @covers vscModelA::next
	 */
	public function testNext()
	{
		
	}

	/**
	 * @covers vscModelA::rewind
	 */
	public function testRewind()
	{
		
	}

	/**
	 * @covers vscModelA::valid
	 * @todo   Implement testValid().
	 */
	public function testValid()
	{
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
		  'This test has not been implemented yet.'
		);
	}

	/**
	 * @covers vscModelA::current
	 * @covers vscModelA::next
	 * @covers vscModelA::rewind
	 * @covers vscModelA::key
	 * @covers vscModelA::valid
	 */
	public function testImplementsIterable()
	{
		$oMirror = new ReflectionClass(get_class($this->object));
		$aProperties = $oMirror->getProperties();
		
		foreach($this->object as $key => $value) {
			var_dump($key, $value);
		}
	}

	/**
	 * @covers vscModelA::count
	 * @todo   Implement testCount().
	 */
	public function testCount()
	{
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
		  'This test has not been implemented yet.'
		);
	}

	/**
	 * @covers vscModelA::__get
	 * @todo   Implement test__get().
	 */
	public function test__get()
	{
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
		  'This test has not been implemented yet.'
		);
	}

	/**
	 * @covers vscModelA::__set
	 * @todo   Implement test__set().
	 */
	public function test__set()
	{
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
		  'This test has not been implemented yet.'
		);
	}

	/**
	 * @covers vscModelA::toArray
	 * @todo   Implement testToArray().
	 */
	public function testToArray()
	{
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
		  'This test has not been implemented yet.'
		);
	}
}