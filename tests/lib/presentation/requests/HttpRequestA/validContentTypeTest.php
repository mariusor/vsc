<?php
namespace tests\lib\presentation\requests\HttpRequestA;
use vsc\presentation\requests\HttpRequestA;

/**
 * @covers \vsc\presentation\requests\HttpRequestA::validContentType()
 */
class validContentType extends \PHPUnit_Framework_TestCase
{
	/**
	 * @return array
	 */
	public function dataProviderValidContentTypes() {
		return [
			'everything' => ['*/*'],
			'image' => ['image/*'],
			'png' => ['image/png'],
			'gif' => ['image/gif'],
			'application' => ['application/*'],
			'xml' => ['application/xml'],
			'json' => ['application/json'],
			// from chromium
			'basic-html' => ['text/html'],
			'xhtml' => ['application/xhtml+xml'],
			'xml-with-param'=> ['application/xml;q=0.9'],
			'webp' => ['image/webp'],
			'everything-with-param' => ['*/*;q=0.8'],
			// firefox
			'html-with-charset-param' => ['text/html;charset=UTF-8'],
			// extra
			'word' => ['application/vnd.ms-word.document']
		];
	}

	/**
	 * @return array
	 */
	public function dataProviderInvalidContentTypes() {
		return [
			'empty' => [''],
			'broken-type' => ['**/*'],
			'broken-subtype' => ['image/**'],
			'no-slash' => ['image png'],
			'minus-for-slash' => ['image-gif'],
			'dot-for-slash' => ['image.gif'],
			'dot-in-type' => ['.application/json'],
			'backslash' => ['text/html\\'],
		];
	}

	/**
	 * @param string $validType
	 * @dataProvider dataProviderValidContentTypes
	 */
	public function testValidateContentTypes($validType) {
		$this->assertTrue(HttpRequestA::validContentType($validType));
	}

	/**
	 * @param string $invalidType
	 * @dataProvider dataProviderInvalidContentTypes
	 */
	public function testInvalidContentTypes($invalidType) {
		$this->assertFalse(HttpRequestA::validContentType($invalidType));
	}
}
