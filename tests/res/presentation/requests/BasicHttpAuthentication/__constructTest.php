<?php
namespace tests\res\presentation\requests\BasicHttpAuthentication;
use vsc\presentation\requests\BasicHttpAuthentication;

/**
 * @covers \vsc\presentation\requests\BasicHttpAuthentication::__construct()
 */
class __construct extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$user = 'test';
		$pw = uniqid('test:');
		$o = new BasicHttpAuthentication($user, $pw);
		$this->assertEquals($user, $o->getUser());
		$this->assertEquals($pw, $o->getPassword());
	}
}
