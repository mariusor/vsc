<?php
namespace tests\res\domain\models\XmlReader;
use vsc\domain\models\XmlReader;
use vsc\domain\models\ModelA;

/**
 * @covers \vsc\domain\models\XmlReader::__construct()
 */
class __construct extends \PHPUnit_Framework_TestCase
{
	public function testBasic__construct()
	{
		$o = new XmlReader();
		$this->assertInstanceOf(ModelA::class, $o);
	}
}
