<?php
class BaseUnitTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @param string $name
	 * @param array  $data
	 * @param string $dataName
	 */
	public function __construct($name = null, array $data = [], $dataName = '') {
		parent::__construct($name, $data, $dataName);
	}

	protected function setUp()
	{
		parent::setUp();
	}

	protected function tearDown()
	{
		parent::tearDown();
	}

	static public function setUpBeforeClass()
	{
		parent::setUpBeforeClass();
	}

	static public function tearDownAfterClass()
	{
		parent::tearDownAfterClass();
	}
}
