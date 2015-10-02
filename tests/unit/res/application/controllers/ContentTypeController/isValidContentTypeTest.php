<?php
namespace tests\res\application\controllers\ContentTypeController;
use vsc\application\controllers\ContentTypeController;

/**
 * @covers \vsc\application\controllers\ContentTypeController::isValidContentType()
 */
class isValidContentType extends \PHPUnit_Framework_TestCase
{
	public function testUseless()
	{
		$this->assertNull(ContentTypeController::isValidContentType('test'));
	}
}
