<?php
namespace tests\domain\models\XmlReader;
use vsc\domain\models\XmlReader;
use vsc\domain\models\ModelA;

/**
 * @covers \vsc\domain\models\XmlReader::__construct()
 */
class __construct extends \BaseUnitTest
{
	public function testBasic__construct()
	{
		$o = new XmlReader();
		$this->assertInstanceOf(ModelA::class, $o);
	}
}
