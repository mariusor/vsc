<?php
/**
 * Created by PhpStorm.
 * User: habarnam
 * Date: 3/1/15
 * Time: 11:58 PM
 */

namespace res\application\sitemaps\ModuleMap;


use vsc\application\sitemaps\ModuleMap;

class __constructTest extends \PHPUnit_Framework_TestCase {

	public function testInitialization () {
		= '';
		$o = new ModuleMap(VSC_FIXTURE_PATH . 'config/map.php', $r);
		$this->assertEquals(VSC_FIXTURE_PATH, $o->getPath());
		$this->assertEquals($r, $o->getRegex());
		$this->assertEquals(VSC_RES_PATH . 'templates' . DIRECTORY_SEPARATOR, $o->getTemplatePath());
	}
}
