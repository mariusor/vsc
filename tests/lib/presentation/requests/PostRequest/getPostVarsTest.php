<?php
namespace tests\lib\presentation\requests\PostRequest;
use vsc\presentation\requests\PostRequest;

/**
 * @covers \vsc\presentation\requests\PostRequest::getPostVars()
 */
class getPostVars extends \PHPUnit_Framework_TestCase
{
	public function testGetEmptyPostVars()
	{
		$_POST = [];
		$o = new PostRequest_underTest_getPostVars();
		$o->initPost($_POST);
		$this->assertEquals([], $o->getPostVars());
	}
}

class PostRequest_underTest_getPostVars {
	use PostRequest {initPost as public;}
}
