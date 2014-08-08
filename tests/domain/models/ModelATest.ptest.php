<?php
use \vsc\domain\models\EmptyModel;
use _fixtures\domain\models\ModelFixture;

class ModelATest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var ModelFixture
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$this->object = new ModelFixture();
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
		$oMirror = new \ReflectionClass($this->object);
		$properties = $oMirror->getProperties();
		$first = array_shift($properties);
		$name = $first->getName();

		// exists
		$this->assertEquals($first->getValue($this->object), $this->object[$name]);

		$this->object->offsetUnset($name);

		// doesn't exist anymore
		$this->assertNull($this->object[$name]);
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
		$oMirror = new \ReflectionClass($this->object);
		$aProperties = $oMirror->getProperties();

		$oReflectionKey = array_shift($aProperties);

		$this->assertEquals($oReflectionKey->name, $this->object->key());
	}

	/**
	 * @covers vscModelA::next
	 */
	public function testNext()
	{
		$oMirror = new \ReflectionClass($this->object);
		$properties = $oMirror->getProperties();

		foreach ($this->object as $name => $value) {
			$this->assertNotEmpty($name);
			$this->assertEquals($name, $this->object->getOffset());
		}
	}

	/**
	 * @covers vscModelA::rewind
	 */
	public function testRewind()
	{
		$oMirror = new \ReflectionClass($this->object);
		$properties = $oMirror->getProperties();

		$fp = array_shift($properties);
		foreach ($this->object as $name => $value) {
			$this->assertNotEmpty($name);
		}
		$this->object->rewind();

		$this->assertEquals($fp->getName(), $this->object->getOffset());
	}

	/**
	 * @covers vscModelA::valid
	 * @todo   Implement testValid().
	 */
	public function testValid()
	{
		$oMirror = new \ReflectionClass($this->object);
		$properties = $oMirror->getProperties();
		foreach ($properties as $key => $property) {
			$this->assertTrue($this->object->valid($property->getName()));
		}

		$rand = uniqid('tst:');
		$this->assertFalse($this->object->valid($rand));
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
		$oMirror = new \ReflectionClass($this->object);

		foreach($this->object as $key => $value) {
			$this->assertTrue($oMirror->hasProperty($key));
			$this->assertEquals($value, $oMirror->getProperty($key)->getValue($this->object));
		}
	}

	/**
	 * @covers vscModelA::count
	 * @todo   Implement testCount().
	 */
	public function testCount()
	{
		$oMirror = new \ReflectionClass($this->object);
		$properties = $oMirror->getProperties();

		$this->assertEquals(count($properties), $this->object->count());
		$this->assertEquals(count($properties), count($this->object));
	}

	/**
	 * @covers vscModelA::__get
	 * @todo   Implement test__get().
	 */
	public function test__get()
	{
		$oMirror = new \ReflectionClass($this->object);
		$properties = $oMirror->getProperties();

		foreach($properties as $key => $property) {
			$name = $property->getName();
			$value = $property->getValue($this->object);
			$this->assertEquals($value, $this->object->__get($name));
			$this->assertEquals($value, $this->object[$name]);
		}
	}

	/**
	 * @covers vscModelA::__set
	 * @todo   Implement test__set().
	 */
	public function test__set()
	{
		$oMirror = new \ReflectionClass($this->object);
		$properties = $oMirror->getProperties();

		foreach($properties as $key => $property) {
			$name = $property->getName();
			$value = uniqid($property . ':__set:');
			$this->object->__set($name, $value);
			$this->assertEquals($value, $this->object->__get($name));
			$this->assertEquals($value, $this->object[$name]);
		}

		foreach($properties as $key => $property) {
			$name = $property->getName();
			$value = uniqid($property . ':[]:');
			$this->object[$name] = $value;
			$this->assertEquals($value, $this->object->__get($name));
			$this->assertEquals($value, $this->object[$name]);
		}
	}

	/**
	 * @covers vscModelA::toArray
	 * @todo   Implement testToArray().
	 */
	public function testToArray()
	{
		$oMirror = new \ReflectionClass($this->object);
		$properties = $oMirror->getProperties();

		$array = $this->object->toArray();

		$this->assertEquals(count($properties), count($array));
		foreach($properties as $key => $property) {
			$name = $property->getName();

			$this->assertArrayHasKey($name, $array);
			$this->assertEquals($oMirror->getProperty($name)->getValue($this->object), $array[$name]);
		}

		foreach($array as $name => $value) {
			$this->assertTrue($oMirror->hasProperty($name));
			$this->assertEquals($value, $oMirror->getProperty($name)->getValue($this->object));
		}

	}
}
