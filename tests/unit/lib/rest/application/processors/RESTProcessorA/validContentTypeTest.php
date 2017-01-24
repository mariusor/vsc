<?php
namespace lib\rest\application\processors\RESTProcessorA;
use vsc\rest\application\processors\RESTProcessorA;
use vsc\presentation\requests\ContentTypes;
use vsc\presentation\requests\HttpRequestA;
use vsc\presentation\requests\RawHttpRequest;

/**
 * @covers \vsc\rest\application\processors\RESTProcessorA::validContentType
 */
class validContentTypeTest extends \BaseUnitTest {
	public function testValidContentTypes () {
		$o = new RESTProcessorA_underTest_validContentType();

		$aContentTypes = array(ContentTypes::EVERYTHING);
		$o->setContentTypes($aContentTypes);
		$this->assertTrue($o->validContentType(ContentTypes::EVERYTHING));
		$this->assertTrue($o->validContentType(ContentTypes::IMAGE));
		$this->assertTrue($o->validContentType(ContentTypes::PNG));
		$this->assertTrue($o->validContentType(ContentTypes::GIF));
		$this->assertTrue($o->validContentType(ContentTypes::APPLICATION));
		$this->assertTrue($o->validContentType(ContentTypes::XML));
		$this->assertTrue($o->validContentType(ContentTypes::JSON));
		$this->assertTrue($o->validContentType(ContentTypes::TEXT));
		$this->assertTrue($o->validContentType(ContentTypes::CSS));

		$aContentTypes = array(ContentTypes::IMAGE);
		$o->setContentTypes($aContentTypes);
		$this->assertFalse($o->validContentType(ContentTypes::EVERYTHING));
		$this->assertTrue($o->validContentType(ContentTypes::IMAGE));
		$this->assertTrue($o->validContentType(ContentTypes::PNG));
		$this->assertTrue($o->validContentType(ContentTypes::GIF));
		$this->assertFalse($o->validContentType(ContentTypes::APPLICATION));
		$this->assertFalse($o->validContentType(ContentTypes::XML));
		$this->assertFalse($o->validContentType(ContentTypes::JSON));
		$this->assertFalse($o->validContentType(ContentTypes::TEXT));
		$this->assertFalse($o->validContentType(ContentTypes::CSS));

		$aContentTypes = array(ContentTypes::PNG);
		$o->setContentTypes($aContentTypes);
		$this->assertFalse($o->validContentType(ContentTypes::EVERYTHING));
		$this->assertFalse($o->validContentType(ContentTypes::IMAGE));
		$this->assertTrue($o->validContentType(ContentTypes::PNG));
		$this->assertFalse($o->validContentType(ContentTypes::GIF));
		$this->assertFalse($o->validContentType(ContentTypes::APPLICATION));
		$this->assertFalse($o->validContentType(ContentTypes::XML));
		$this->assertFalse($o->validContentType(ContentTypes::JSON));
		$this->assertFalse($o->validContentType(ContentTypes::TEXT));
		$this->assertFalse($o->validContentType(ContentTypes::CSS));

		$aContentTypes = array(ContentTypes::GIF);
		$o->setContentTypes($aContentTypes);
		$this->assertFalse($o->validContentType(ContentTypes::EVERYTHING));
		$this->assertFalse($o->validContentType(ContentTypes::IMAGE));
		$this->assertFalse($o->validContentType(ContentTypes::PNG));
		$this->assertTrue($o->validContentType(ContentTypes::GIF));
		$this->assertFalse($o->validContentType(ContentTypes::APPLICATION));
		$this->assertFalse($o->validContentType(ContentTypes::XML));
		$this->assertFalse($o->validContentType(ContentTypes::JSON));
		$this->assertFalse($o->validContentType(ContentTypes::TEXT));
		$this->assertFalse($o->validContentType(ContentTypes::CSS));

		$aContentTypes = array(ContentTypes::APPLICATION);
		$o->setContentTypes($aContentTypes);
		$this->assertFalse($o->validContentType(ContentTypes::EVERYTHING));
		$this->assertFalse($o->validContentType(ContentTypes::IMAGE));
		$this->assertFalse($o->validContentType(ContentTypes::PNG));
		$this->assertFalse($o->validContentType(ContentTypes::GIF));
		$this->assertTrue($o->validContentType(ContentTypes::APPLICATION));
		$this->assertTrue($o->validContentType(ContentTypes::XML));
		$this->assertTrue($o->validContentType(ContentTypes::JSON));
		$this->assertFalse($o->validContentType(ContentTypes::TEXT));
		$this->assertFalse($o->validContentType(ContentTypes::CSS));
	}
}

class RESTProcessorA_underTest_validContentType extends RESTProcessorA {
	protected $validContentTypes = array ();

	public function setContentTypes ($aContentTypes) {
		$this->validContentTypes = $aContentTypes;
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
		// TODO: Implement handleGet() method.
	}

	public function handleHead(HttpRequestA $oRequest)
	{
		// TODO: Implement handleHead() method.
	}

	public function handlePost(HttpRequestA $oRequest)
	{
		// TODO: Implement handlePost() method.
	}

	public function handlePut(RawHttpRequest $oRequest)
	{
		// TODO: Implement handlePut() method.
	}

	public function handleDelete(RawHttpRequest $oRequest)
	{
		// TODO: Implement handleDelete() method.
	}
}
