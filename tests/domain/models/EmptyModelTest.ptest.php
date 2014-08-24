<?php
use \vsc\domain\models\EmptyModel;

class EmptyModelTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var EmptyModel
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$this->object = new EmptyModel;
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown()
	{
	}

	/**
	 * @covers \vsc\domain\models\EmptyModel::setPageTitle
	 */
	public function testSetGetPageTitle()
	{
		$sTitle = 'test title';
		$this->object->setPageTitle($sTitle);

		$this->assertEquals($this->object->getPageTitle(), $sTitle);
	}

	/**
	 * @covers \vsc\domain\models\EmptyModel::setPageContent
	 */
	public function testSetGetPageContent()
	{
		$sContent = 'test content <p>some shit</p>';
		$this->object->setPageContent($sContent);

		$this->assertEquals($this->object->getPageContent(), $sContent);
	}
}
