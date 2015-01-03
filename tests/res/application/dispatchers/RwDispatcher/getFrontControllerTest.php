<?php
namespace tests\res\application\dispatchers\RwDispatcher;
use fixtures\presentation\requests\PopulatedRequest;
use vsc\application\dispatchers\RwDispatcher;
use vsc\infrastructure\vsc;

/**
 * @covers \vsc\application\dispatchers\RwDispatcher::getFrontController()
 */
class getFrontController extends \PHPUnit_Framework_TestCase
{
	public function testBasicGetFrontController ()
	{
		$sFixturePath = VSC_FIXTURE_PATH . 'config' . DIRECTORY_SEPARATOR;
		$o = new RwDispatcher();

		$this->assertTrue ( is_file ( $sFixturePath . 'map.php' ) );
		$this->assertTrue ( $o->loadSiteMap ( $sFixturePath . 'map.php' ) );

		$oRequest = new PopulatedRequest();
		vsc::getEnv ()->setHttpRequest ( $oRequest );

		try {
			$oFront = $o->getFrontController ();

			$this->assertInstanceOf ( \vsc\application\controllers\FrontControllerA::class, $oFront );
		} catch ( \Exception $e ) {
			$this->assertInstanceOf ( \vsc\presentation\responses\ExceptionResponseError::class, $e );
		}
	}

}
