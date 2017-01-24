<?php
namespace tests\lib\presentation\views\ViewA;
use mocks\presentation\views\testView;
use vsc\application\sitemaps\ClassMap;
use mocks\domain\models\ModelFixture;
use vsc\Exception;
use vsc\ExceptionPath;

/**
 * @covers \vsc\presentation\views\ViewA::fetch()
 */
class fetch extends \BaseUnitTest
{
	public function testFetch ()
	{
		$o = new testView();

		$t = '';
		try {
			$o->fetch ( $t );
		} catch (\Exception $e) {
			$this->assertInstanceOf(Exception::class, $e);
			$this->assertInstanceOf(ExceptionPath::class, $e);
		}

		$t = 'main.tpl.php';
		$oMap = new ClassMap(__FILE__, '\A.*\Z');

		$oMap->setTemplatePath(VSC_MOCK_PATH . 'templates/');
		$oMap->setTemplate($t);

		$o->setMap($oMap);

		$f = new ModelFixture();
		$o->setModel ($f);

		$output = $o->fetch($t);
		$this->assertEquals(file_get_contents(VSC_MOCK_PATH . 'templates/' . $t), $output);
	}
}
