<?php
namespace tests\res\infrastructure\Object;
use fixtures\presentation\views\NullView;
use vsc\application\controllers\FrontControllerA;
use vsc\application\processors\ProcessorA;
use vsc\domain\models\ModelA;
use vsc\infrastructure\Base;
use vsc\infrastructure\Object;
use vsc\presentation\requests\HttpRequestA;
use vsc\presentation\requests\RawHttpRequest;
use vsc\rest\application\controllers\RESTController;
use vsc\rest\application\processors\RESTProcessorA;

/**
 * @covers \vsc\infrastructure\Object::isValid()
 */
class isValid extends \PHPUnit_Framework_TestCase
{
	public function testIsValid () {
		$TestVar = new Base();
		$this->assertTrue (Base::isValid($TestVar));
		$this->assertTrue (Object::isValid($TestVar));

		$TestVar = new RESTProcessorA_underTest_isValid();
		$this->assertTrue (RESTProcessorA_underTest_isValid::isValid($TestVar));
		$this->assertTrue (RESTProcessorA::isValid($TestVar));
		$this->assertTrue (ProcessorA::isValid($TestVar));
		$this->assertTrue (Object::isValid($TestVar));

		$TestVar = new ProcessorA_underTest_isValid();
		$this->assertTrue (ProcessorA_underTest_isValid::isValid($TestVar));
		$this->assertTrue (ProcessorA::isValid($TestVar));
		$this->assertTrue (Object::isValid($TestVar));

		$TestVar = new RESTController();
		$this->assertTrue (RESTController::isValid($TestVar));
		$this->assertTrue (FrontControllerA::isValid($TestVar));
		$this->assertTrue (Object::isValid($TestVar));

		$TestVar = new FrontControllerA_underTest_isValid();
		$this->assertTrue (FrontControllerA_underTest_isValid::isValid($TestVar));
		$this->assertTrue (FrontControllerA::isValid($TestVar));
		$this->assertTrue (Object::isValid($TestVar));

		$TestVar = new ModelA_underTest_isValid();
		$this->assertTrue (ModelA_underTest_isValid::isValid($TestVar));
		$this->assertTrue (ModelA::isValid($TestVar));
	}
}

class FrontControllerA_underTest_isValid extends FrontControllerA {
	public function getDefaultView() {
		return new NullView();
	}
}

class ProcessorA_underTest_isValid extends ProcessorA {
	public $return;
	protected $aLocalVars = array ('test' => null);

	public function init () {}

	public function handleRequest (HttpRequestA $oHttpRequest) {
		return $this->return;
	}
}


class RESTProcessorA_underTest_isValid extends RESTProcessorA {
	public function setRequestMethods ($aContentTypes) {
		$this->validRequestMethods = $aContentTypes;
	}

	/**
	 * @return void
	 */
	public function init()
	{
		// TODO: Implement init() method.
	}

	public function handleGet(HttpRequestA $oRequest)
	{
		return new ModelFixture();
	}

	public function handleHead(HttpRequestA $oRequest)
	{
		return $this->handleGet($oRequest);
	}

	public function handlePost(HttpRequestA $oRequest)
	{
		return $this->handleGet($oRequest);
	}

	public function handlePut(RawHttpRequest $oRequest)
	{
		return $this->handleGet($oRequest);
	}

	public function handleDelete(RawHttpRequest $oRequest)
	{
		return $this->handleGet($oRequest);
	}
}

class ModelA_underTest_isValid extends ModelA {
	public $test = 666;
	public $cucu;

	private $needsGetter = true;

	public function valid ($sName = null) {
		return parent::valid($sName);
	}

	// Countable interface
	public function count () {
		return parent::count();
	}

	/**
	 * It should add a new property to the object
	 * @param string $sName
	 * @param mixed $mValue
	 */
	public function addProperty ($sName, $mValue, $bIfNonExistent = false) {
		parent::addProperty($sName, $mValue, $bIfNonExistent);
	}

	public function getPropertyNames ($bAll = false) {
		return parent::getPropertyNames($bAll);
	}

	/**
	 * @param bool $bIncludeNonPublic
	 * @return array
	 */
	public function getProperties ($bIncludeNonPublic = false) {
		return parent::getProperties($bIncludeNonPublic);
	}

	/**
	 * recursively transform all properties into arrays
	 */
	public function toArray () {
		return parent::toArray();
	}

	/**
	 * @return bool
	 */
	public function getNeedsGetter() {
		return $this->needsGetter;
	}
}
