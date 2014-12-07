<?php
use fixtures\domain\models\ModelFixture;

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
	 * @covers \vsc\domain\models\ModelA::setOffset
	 */
	public function testGetSetOffset()
	{
		$sOffset = 'test';
		$this->object->setOffset($sOffset);
		$this->assertEquals($sOffset, $this->object->getOffset());
	}

	/**
	 * @covers \vsc\domain\models\ModelA::offsetSet
	 */
	public function testOffsetSet()
	{
		$sOffset = 'test';
		$sValue = 'asd';

		$this->object->offsetSet($sOffset, $sValue);
		$this->assertEquals($sValue, $this->object[$sOffset]);
	}

	/**
	 * @covers \vsc\domain\models\ModelA::offsetExists
	 */
	public function testOffsetExists()
	{
		$sOffset = 'test';
		$this->assertTrue($this->object->offsetExists($sOffset));
	}

	/**
	 * @covers \vsc\domain\models\ModelA::offsetGet
	 */
	public function testOffsetGet()
	{
		$sOffset = 'test';
		$this->assertEquals(666, $this->object[$sOffset]);
		$this->assertEquals(666, $this->object->offsetGet($sOffset));
		$this->assertEquals(666, $this->object->__get($sOffset));

		$sOffset1 = 'needsGetter';
		$this->assertTrue($this->object->__get($sOffset1));
		$this->assertTrue($this->object->$sOffset1);
		$this->assertTrue($this->object->getNeedsGetter());
	}

	/**
	 * @covers \vsc\domain\models\ModelA::offsetExists
	 */
	public function testOffsetDoesntExist()
	{
		$sOffset = 'nonexistent';
		$this->assertFalse($this->object->offsetExists($sOffset));
	}

	/**
	 * @covers \vsc\domain\models\ModelA::offsetUnset
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
	 * @covers \vsc\domain\models\ModelA::current
	 */
	public function testCurrentAtInitialization()
	{
		$this->assertEquals($this->object->test, $this->object->current());
	}

	/**
	 * @covers \vsc\domain\models\ModelA::current
	 */
	public function testCurrentAtAttribution()
	{
		$sOffset = 'test';
		$this->object->$sOffset = 'test';

		$this->assertEquals($sOffset, $this->object->current());
	}

	/**
	 * @covers \vsc\domain\models\ModelA::current
	 */
	public function testCurrentAtAttributionUsingBraketOperator()
	{
		$sOffset = 'test';
		$this->object[$sOffset] = 'test';

		$this->assertEquals($sOffset, $this->object->current());
	}

	/**
	 * @covers \vsc\domain\models\ModelA::key()
	 */
	public function testKeyAtInitialization()
	{
		$oMirror = new \ReflectionClass($this->object);
		$aProperties = $oMirror->getProperties();

		$oReflectionKey = array_shift($aProperties);

		$this->assertEquals($oReflectionKey->name, $this->object->key());
	}

	/**
	 * @covers \vsc\domain\models\ModelA::next
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
	 * @covers \vsc\domain\models\ModelA::rewind
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
	 * @covers \vsc\domain\models\ModelA::valid
	 */
	public function testValid()
	{
		$oMirror = new \ReflectionClass($this->object);
		$properties = $oMirror->getProperties(ReflectionProperty::IS_PUBLIC);
		foreach ($properties as $key => $property) {
			$this->assertTrue ( $this->object->valid ( $property->getName () ) );
		}

		$rand = uniqid('tst:');
		$this->assertFalse($this->object->valid($rand));
	}

	/**
	 * @covers \vsc\domain\models\ModelA::current
	 * @covers \vsc\domain\models\ModelA::next
	 * @covers \vsc\domain\models\ModelA::rewind
	 * @covers \vsc\domain\models\ModelA::key
	 * @covers \vsc\domain\models\ModelA::valid
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
	 * @covers \vsc\domain\models\ModelA::count
	 */
	public function testCount()
	{
		$oMirror = new \ReflectionClass($this->object);
		$properties = $oMirror->getProperties(ReflectionProperty::IS_PUBLIC);

		$this->assertEquals(count($properties), $this->object->count());
		$this->assertEquals(count($properties), count($this->object));
	}

	/**
	 * @covers \vsc\domain\models\ModelA::__get
	 */
	public function test__get()
	{
		$oMirror = new \ReflectionClass($this->object);
		$properties = $oMirror->getProperties(ReflectionProperty::IS_PUBLIC);

		foreach($properties as $key => $property) {
			$name = $property->getName();
			$value = $property->getValue($this->object);
			$this->assertEquals($value, $this->object->__get($name));
			$this->assertEquals($value, $this->object[$name]);
		}
	}

	/**
	 * @covers \vsc\domain\models\ModelA::__set
	 */
	public function test__set()
	{
		$oMirror = new \ReflectionClass($this->object);
		$properties = $oMirror->getProperties(ReflectionProperty::IS_PUBLIC);

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
	 * @covers \vsc\domain\models\ModelA::toArray
	 */
	public function testToArray()
	{
		$oMirror = new \ReflectionClass($this->object);
		$properties = $oMirror->getProperties(ReflectionProperty::IS_PUBLIC);

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
