<?php
namespace tests\lib\presentation\requests\PostRequestTrait;
use vsc\presentation\requests\PostRequestTrait;

/**
 * @covers \vsc\presentation\requests\PostRequestTrait::getPostVars()
 */
class getPostVars extends \BaseUnitTest
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
	use PostRequestTrait {initPost as public;}
}
