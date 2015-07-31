<?php
namespace lib\domain\models\ModelA;
use vsc\domain\models\ModelA;

/**
 * @covers \vsc\domain\models\ModelA::getProperties()
 */
class getPropertiesTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @covers \vsc\domain\models\ModelA::getProperties
	 */
	public function testBasicGetProperties ()
	{
		$o = new ModelA_underTest_getProperties();

		$ToArray = $o->getProperties();

		$oMirror = new \ReflectionClass($o);
		$aProperties = $oMirror->getProperties(\ReflectionProperty::IS_PUBLIC);

		$this->assertEquals(count($ToArray), count($aProperties));
	}

	/**
	 * @covers \vsc\domain\models\ModelA::getProperties
	 */
	public function testGetPropertiesWithNonPublic ()
	{
		$o = new ModelA_underTest_getProperties();

		$ToArray = $o->getProperties(true);

		$oMirror = new \ReflectionClass($o);
		$aPublicProperties = $oMirror->getProperties(\ReflectionProperty::IS_PUBLIC);
		$this->assertEquals(3, count($aPublicProperties));
		$aProtectedProperties = $oMirror->getProperties(\ReflectionProperty::IS_PROTECTED);
		$this->assertEquals(3, count($aProtectedProperties)); // this includes IteratorT::$_current
		$aPrivateProperties = $oMirror->getProperties(\ReflectionProperty::IS_PRIVATE);
		$this->assertEquals(1, count($aPrivateProperties));

		$aProperties = array_merge($aPrivateProperties, $aProtectedProperties, $aPublicProperties);

		$this->assertEquals(count($ToArray), count($aProperties));
	}
}

class ModelA_underTest_getProperties extends ModelA {
	public $test;
	public $ana = 'test';
	public $gigel = 0x123F;
	protected $mere = 123;
	protected $grr = 6.66;

	private $private = 'saf';

	/**
	 * @param bool $bIncludeProtected
	 * @return array
	 */
	public function getProperties ($bIncludeProtected = false) {
		return parent::getProperties($bIncludeProtected);
	}
}
