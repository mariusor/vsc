<?php
 /**
 * @author Marius Orcsik <marius@habarnam.ro>
 * @created 2015-02-24
 */
namespace res\config;

use fixtures\presentation\requests\PopulatedRequest;
use vsc\application\controllers\JsonController;
use vsc\application\controllers\PlainTextController;
use vsc\application\controllers\RssController;
use vsc\application\controllers\Html5Controller;
use vsc\application\dispatchers\RwDispatcher;
use vsc\application\processors\NotFoundProcessor;
use vsc\application\sitemaps\ClassMap;
use vsc\application\sitemaps\MappingA;
use vsc\application\sitemaps\ModuleMap;
use vsc\infrastructure\vsc;

class mapTest extends \PHPUnit_Framework_TestCase {

	protected function setUp  () {
		$req = new PopulatedRequest();
		vsc::getEnv()->setHttpRequest($req);
	}

	protected function tearDown  () {
		vsc::setInstance(new vsc());
	}

	public function uriProvider () {
		return [
			'empty uri' => ['/'],
			'empty path with json' => ['/a.json'],
			'empty path with rss' => ['/a.rss'],
			'empty path with txt' => ['/a.txt'],
			'random uri' => [uniqid('/test/')],
			'random path with json' => [uniqid('/') . '.json'],
			'random path with rss' => [uniqid('/') . '.rss'],
			'random path with txt' => [uniqid('/') . '.txt'],
		];
	}

	/**
	 * @param string $uri
	 * @throws \Exception
	 * @throws \vsc\application\sitemaps\ExceptionSitemap
	 * @dataProvider uriProvider
	 */
	public function testGetProcessorMap ($uri) {
		vsc::getEnv()->getHttpRequest()->setUri($uri);

		$o = new RwDispatcher();
		$this->assertTrue($o->loadSiteMap(VSC_RES_PATH . 'config/map.php'));

		$map = $o->getCurrentProcessorMap();

		$this->assertInstanceOf(MappingA::class, $map);
		$this->assertInstanceOf(ClassMap::class, $map);
		$this->assertEquals(NotFoundProcessor::class, $map->getPath());
		$this->assertEquals('404.php', $map->getTemplate());
		$this->assertEquals(VSC_RES_PATH . 'templates' . DIRECTORY_SEPARATOR, $map->getTemplatePath());
	}

	/**
	 * @param string $uri
	 * @throws \Exception
	 * @throws \vsc\application\sitemaps\ExceptionSitemap
	 * @dataProvider uriProvider
	 */
	public function testGetControllerMapWithEmptyRequest($uri) {
		vsc::getEnv()->getHttpRequest()->setUri($uri);

		$o = new RwDispatcher();
		$this->assertTrue($o->loadSiteMap(VSC_RES_PATH . 'config/map.php'));

		$controllerMap = $o->getCurrentControllerMap();
		$this->assertInstanceOf(MappingA::class, $controllerMap);
		$this->assertInstanceOf(ClassMap::class, $controllerMap);

		$processorMap = $o->getCurrentProcessorMap();

		if ($processorMap->getPath() != NotFoundProcessor::class) {
			if (stristr($uri, 'json') == 'json') {
				$this->assertEquals(JsonController::class, $controllerMap->getPath());
			} elseif (stristr($uri, 'rss') == 'rss') {
				$this->assertEquals(RssController::class, $controllerMap->getPath());
			} elseif (stristr($uri, 'txt') == 'txt') {
				$this->assertEquals(PlainTextController::class, $controllerMap->getPath());
			} else {
				$this->assertEquals(Html5Controller::class, $controllerMap->getPath());
			}
		} else {
			// if the processor is not found we always serve as html5
			$this->assertEquals(Html5Controller::class, $controllerMap->getPath());
		}

	}

	public function testParentModuleMap() {
		vsc::getEnv()->getHttpRequest()->setUri('/');

		$o = new RwDispatcher();
		$this->assertTrue($o->loadSiteMap(VSC_RES_PATH . 'config/map.php'));

		$moduleMap = $o->getCurrentModuleMap();
		$this->assertInstanceOf(MappingA::class, $moduleMap);
		$this->assertInstanceOf(ModuleMap::class, $moduleMap);
		$this->assertEquals(VSC_RES_PATH . 'templates' . DIRECTORY_SEPARATOR, $moduleMap->getTemplatePath());
		$this->assertEquals(VSC_RES_PATH . 'templates' . DIRECTORY_SEPARATOR, $moduleMap->getMainTemplatePath());
		$this->assertEquals('main.php', $moduleMap->getMainTemplate());

	}

}
