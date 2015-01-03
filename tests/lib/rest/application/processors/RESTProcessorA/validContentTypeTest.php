<?php
namespace lib\rest\application\processors\RESTProcessorA;
use vsc\rest\application\processors\RESTProcessorA;
use vsc\presentation\requests\ContentTypes;
use vsc\presentation\requests\HttpRequestA;
use vsc\presentation\requests\RawHttpRequest;

/**
 * @covers \vsc\rest\application\processors\RESTProcessorA::validContentType
 */
class validContentTypeTest extends \PHPUnit_Framework_TestCase {
	public function testValidContentTypes () {
		$o = new RESTProcessorA_underTest_validContentType();

		$aContentTypes = array(ContentTypes::Everything);
		$o->setContentTypes($aContentTypes);
		$this->assertTrue($o->validContentType(ContentTypes::Everything));
		$this->assertTrue($o->validContentType(ContentTypes::Image));
		$this->assertTrue($o->validContentType(ContentTypes::Png));
		$this->assertTrue($o->validContentType(ContentTypes::Gif));
		$this->assertTrue($o->validContentType(ContentTypes::Application));
		$this->assertTrue($o->validContentType(ContentTypes::Xml));
		$this->assertTrue($o->validContentType(ContentTypes::Json));
		$this->assertTrue($o->validContentType(ContentTypes::Text));
		$this->assertTrue($o->validContentType(ContentTypes::Css));

		$aContentTypes = array(ContentTypes::Image);
		$o->setContentTypes($aContentTypes);
		$this->assertFalse($o->validContentType(ContentTypes::Everything));
		$this->assertTrue($o->validContentType(ContentTypes::Image));
		$this->assertTrue($o->validContentType(ContentTypes::Png));
		$this->assertTrue($o->validContentType(ContentTypes::Gif));
		$this->assertFalse($o->validContentType(ContentTypes::Application));
		$this->assertFalse($o->validContentType(ContentTypes::Xml));
		$this->assertFalse($o->validContentType(ContentTypes::Json));
		$this->assertFalse($o->validContentType(ContentTypes::Text));
		$this->assertFalse($o->validContentType(ContentTypes::Css));

		$aContentTypes = array(ContentTypes::Png);
		$o->setContentTypes($aContentTypes);
		$this->assertFalse($o->validContentType(ContentTypes::Everything));
		$this->assertFalse($o->validContentType(ContentTypes::Image));
		$this->assertTrue($o->validContentType(ContentTypes::Png));
		$this->assertFalse($o->validContentType(ContentTypes::Gif));
		$this->assertFalse($o->validContentType(ContentTypes::Application));
		$this->assertFalse($o->validContentType(ContentTypes::Xml));
		$this->assertFalse($o->validContentType(ContentTypes::Json));
		$this->assertFalse($o->validContentType(ContentTypes::Text));
		$this->assertFalse($o->validContentType(ContentTypes::Css));

		$aContentTypes = array(ContentTypes::Gif);
		$o->setContentTypes($aContentTypes);
		$this->assertFalse($o->validContentType(ContentTypes::Everything));
		$this->assertFalse($o->validContentType(ContentTypes::Image));
		$this->assertFalse($o->validContentType(ContentTypes::Png));
		$this->assertTrue($o->validContentType(ContentTypes::Gif));
		$this->assertFalse($o->validContentType(ContentTypes::Application));
		$this->assertFalse($o->validContentType(ContentTypes::Xml));
		$this->assertFalse($o->validContentType(ContentTypes::Json));
		$this->assertFalse($o->validContentType(ContentTypes::Text));
		$this->assertFalse($o->validContentType(ContentTypes::Css));

		$aContentTypes = array(ContentTypes::Application);
		$o->setContentTypes($aContentTypes);
		$this->assertFalse($o->validContentType(ContentTypes::Everything));
		$this->assertFalse($o->validContentType(ContentTypes::Image));
		$this->assertFalse($o->validContentType(ContentTypes::Png));
		$this->assertFalse($o->validContentType(ContentTypes::Gif));
		$this->assertTrue($o->validContentType(ContentTypes::Application));
		$this->assertTrue($o->validContentType(ContentTypes::Xml));
		$this->assertTrue($o->validContentType(ContentTypes::Json));
		$this->assertFalse($o->validContentType(ContentTypes::Text));
		$this->assertFalse($o->validContentType(ContentTypes::Css));
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
