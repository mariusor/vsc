<?php
namespace tests\res\rest\presentation\requests\RESTRequest;
use vsc\rest\presentation\requests\RESTRequest;

/**
 * @covers \vsc\rest\presentation\requests\RESTRequest::validContentType()
 */
class validContentType extends \BaseUnitTest
{
	public function testValidContentType () {
		$o = new RESTRequest();
		$this->assertTrue($o->validContentType('application/json'));
		$this->assertFalse($o->validContentType('text/plain'));
	}
}
