<?php
namespace tests\lib\presentation\views\ViewA;
use fixtures\presentation\views\testView;
use vsc\application\sitemaps\ClassMap;
use vsc\domain\models\EmptyModel;

/**
 * @covers \vsc\presentation\views\ViewA::getTitle()
 */
class getTitle extends \PHPUnit_Framework_TestCase
{
	public function testGetTitleFromMap()
	{
		$o = new testView();

		try {
			$this->assertEmpty ( $o->getTitle () );
		} catch (\Exception $e) {
			// catching a model exception
		}
		$oMap = new ClassMap(__FILE__, '\A.*\Z');

		$oMap->setTemplatePath(VSC_FIXTURE_PATH . 'templates/');
		$oMap->setTemplate('main.tpl.php');

		$o->setMap($oMap);
		$this->assertEmpty ( $o->getTitle () );

		$t = uniqid('test:');
		$oMap->setTitle($t);
		$this->assertEquals ($t, $o->getTitle () );
	}

	public function testGetTitleFromModel()
	{
		$o = new testView();

		try {
			$this->assertEmpty ( $o->getTitle () );
		} catch (\Exception $e) {
			// catching a model exception
		}

		$oMap = new ClassMap(__FILE__, '\A.*\Z');

		$oMap->setTemplatePath(VSC_FIXTURE_PATH . 'templates/');
		$oMap->setTemplate('main.tpl.php');

		$o->setMap($oMap);
		$f = new EmptyModel();
		$o->setModel ($f);

		$this->assertEmpty ( $o->getTitle () );

		$t = uniqid('test:');
		$f->setPageTitle($t);
		$this->assertEquals ($t, $o->getTitle () );
	}
}
