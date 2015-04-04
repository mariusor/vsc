<?php
namespace res\rest\application\processors\RESTProcessorA;
use vsc\rest\application\processors\RESTProcessorA;
use vsc\presentation\requests\RawHttpRequest;
use vsc\presentation\requests\HttpRequestA;

/**
 * Class validContentTypeTest
 * @package res\rest\application\processors\RESTProcessorA
 * @covers \vsc\rest\application\processors\RESTProcessorA::validContentType()
 */
class validContentTypeTest extends \PHPUnit_Framework_TestCase {

	public function providerForContentType() {
		return [
			[ 'all' => '*/*'],
			[ 'gif' => 'image/gif'],
			[ 'jpeg' => 'image/jpg'],
			[ 'png' => 'image/png'],
			[ 'bmp' => 'image/bmp'],
			[ 'javascript' => 'application/javascript'],
			[ 'json' => 'application/json'],
			[ 'xml' => 'application/xml'],
			[ 'html' => 'application/html'],
		];
	}

	/**
	 * @param string $type
	 * @dataProvider providerForContentType
	 */
	public function testAllValid ($type) {
		$o = new RESTProcessorA_underTest_validContentType();
		$this->assertTrue($o->validContentType($type));
	}

	/**
	 * @param string $type
	 * @dataProvider providerForContentType
	 */
	public function testValidImages ($type) {
		$o = new RESTProcessorA_underTest_validContentType();
		$o->validContentTypes = ['image/*'];
		list($t1, $t2) = explode('/', $type);
		if ($t1 == 'image') {
			$this->assertTrue($o->validContentType($type));
		} else {
			$this->assertFalse($o->validContentType($type));
		}
	}
	/**
	 * @param string $type
	 * @dataProvider providerForContentType
	 */
	public function testValidApplication ($type) {
		$o = new RESTProcessorA_underTest_validContentType();
		$o->validContentTypes = ['application/*'];
		list($t1, $t2) = explode('/', $type);
		if ($t1 == 'application') {
			$this->assertTrue($o->validContentType($type));
		} else {
			$this->assertFalse($o->validContentType($type));
		}
	}
}

class RESTProcessorA_underTest_validContentType extends RESTProcessorA {
	public $validContentTypes = ['*/*'];
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
