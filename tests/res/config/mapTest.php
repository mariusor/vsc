<?php
 /**
 * @author Marius Orcsik <marius.orcsik@rocket-internet.de>
 * @copyright Copyright (c) 2014 Rocket Internet GmbH, Johannisstraße 20, 10117 Berlin, http://www.rocket-internet.de
 * @created 2015-02-24
 */
namespace res\config;

use fixtures\presentation\requests\PopulatedRequest;
use vsc\application\dispatchers\RwDispatcher;
use vsc\application\sitemaps\ClassMap;
use vsc\application\sitemaps\MappingA;
use vsc\infrastructure\vsc;

class mapTest extends \PHPUnit_Framework_TestCase {

	protected function setUp  () {
		$req = new PopulatedRequest();
		vsc::getEnv()->setHttpRequest($req);
	}

	public function testGetCurrentMapWithoutReqquest() {
		vsc::getEnv()->getHttpRequest()->setUri('');

		$o = new RwDispatcher();
		$this->assertTrue($o->loadSiteMap(VSC_RES_PATH . 'config/map.php'));

		$map = $o->getCurrentProcessorMap();

		$this->assertInstanceOf(MappingA::class, $map);
		$this->assertInstanceOf(ClassMap::class, $map);
		$this->assertEquals(\vsc\application\processors\NotFoundProcessor::class, $map->getPath());
		$this->assertEquals('404.php', $map->getTemplate());
		$this->assertEquals(VSC_RES_PATH . 'templates' . DIRECTORY_SEPARATOR, $map->getTemplatePath());
	}

}
