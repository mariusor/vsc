<?php
use vsc\application\sitemaps\ProcessorMap;
use vsc\domain\models\EmptyModel;
use vsc\presentation\views\ViewA;

use _fixtures\presentation\views\testView;
use _fixtures\domain\models\ModelFixture;

class DefaultViewTest extends \PHPUnit_Framework_TestCase {
	/**
	 * @var testView
	 */
	public $state;

	public function setUp () {
		$this->state = new testView();
	}

	public function tearDown () {
		// @todo
	}

	public function testGetMainTemplateEmpty () {
		$path = $this->state->getMainTemplate();
		$this->assertEmpty($path);
	}

	public function testSetMainTemplate () {
		$t = VSC_FIXTURE_PATH . 'templates/main.tpl.php';
		$this->state->setMainTemplate($t);

		$this->assertEquals($t, $this->state->getMainTemplate());
	}

	public function testSetMainTemplateBroken () {
		$t = '';
		try {
			$this->state->setMainTemplate ( $t );
		} catch (Exception $e) {
			$this->assertInstanceOf('\\vsc\\ExceptionPath', $e);
		}

		$this->assertEmpty($this->state->getMainTemplate());
	}

	public function testGetTemplateEmpty () {
		$path = $this->state->getTemplate();
		$this->assertEmpty($path);
	}

	public function testSetTemplate () {
		$oMap = new ProcessorMap(__FILE__, '\A.*\Z');

		$oMap->setTemplatePath(VSC_FIXTURE_PATH . 'templates/');
		$oMap->setTemplate('main.tpl.php');

		$this->state->setMap($oMap);

		$this->assertEquals($oMap->getTemplate(), $this->state->getTemplate());
		$this->assertEquals($oMap->getTemplatePath(), $this->state->getTemplatePath());
	}

	public function testSetTemplateBroken () {
		$t = '';
		try {
			$this->state->setTemplate ( $t );
		} catch (Exception $e) {
			$this->assertInstanceOf('\\vsc\\ExceptionPath', $e);
		}

		$this->assertEmpty($this->state->getTemplate());
	}

	public function testGetContentTypeEmpty() {
		$this->assertEmpty($this->state->getContentType());
	}

	public function testGetViewFolderEmpty() {
		$this->assertEmpty($this->state->getViewFolder());
	}

	public function testGetViewFolder() {
		$t = 'test';
		$this->state->setFolder($t);
		$this->assertEquals($t, $this->state->getViewFolder());
	}

	public function testGetModel () {
		try {
			// empty
			$this->state->getModel ();
		} catch (Exception $e) {
			$this->assertInstanceOf('\\vsc\\presentation\\views\\ExceptionView', $e);
		}

		$f = new ModelFixture();
		$this->state->setModel ($f);

		$m = $this->state->getModel();

		$this->assertInstanceOf('\\vsc\\domain\\models\\ModelA', $m);
		$this->assertInstanceOf('\\_fixtures\\domain\\models\\ModelFixture', $m);
		$this->assertEquals($f, $m);
	}

	public function testGetTitleFromMap() {
		try {
			$this->assertEmpty ( $this->state->getTitle () );
		} catch (Exception $e) {
			// catching a model exception
		}
		$oMap = new ProcessorMap(__FILE__, '\A.*\Z');

		$oMap->setTemplatePath(VSC_FIXTURE_PATH . 'templates/');
		$oMap->setTemplate('main.tpl.php');

		$this->state->setMap($oMap);
		$this->assertEmpty ( $this->state->getTitle () );

		$t = uniqid('test:');
		$oMap->setTitle($t);
		$this->assertEquals ($t, $this->state->getTitle () );
	}

	public function testGetTitleFromModel() {
		try {
			$this->assertEmpty ( $this->state->getTitle () );
		} catch (Exception $e) {
			// catching a model exception
		}

		$oMap = new ProcessorMap(__FILE__, '\A.*\Z');

		$oMap->setTemplatePath(VSC_FIXTURE_PATH . 'templates/');
		$oMap->setTemplate('main.tpl.php');

		$this->state->setMap($oMap);
		$f = new EmptyModel();
		$this->state->setModel ($f);

		$this->assertEmpty ( $this->state->getTitle () );

		$t = uniqid('test:');
		$f->setPageTitle($t);
		$this->assertEquals ($t, $this->state->getTitle () );
	}

	public function testFetch () {
		$t = '';
		try {
			$this->state->fetch ( $t );
		} catch (Exception $e) {
			$this->assertInstanceOf ('\\vsc\\ExceptionPath', $e);
		}

		$t = 'main.tpl.php';
		$oMap = new ProcessorMap(__FILE__, '\A.*\Z');

		$oMap->setTemplatePath(VSC_FIXTURE_PATH . 'templates/');
		$oMap->setTemplate($t);

		$this->state->setMap($oMap);

		$f = new ModelFixture();
		$this->state->setModel ($f);

		$output = $this->state->fetch($t);
		$this->assertEquals(file_get_contents(VSC_FIXTURE_PATH . 'templates/' . $t), $output);
	}

	public function testGetOutput() {
		try {
			$this->state->getOutput();
		} catch (Exception $e) {
			$this->assertInstanceOf ('\\vsc\\presentation\\views\\ExceptionView', $e);
		}

		$t = 'main.tpl.php';
		$oMap = new ProcessorMap(__FILE__, '\A.*\Z');
		$oMap->setTemplatePath(VSC_FIXTURE_PATH . 'templates/');
		$oMap->setTemplate($t);

		$this->state->setMap($oMap);

		$f = new ModelFixture();
		$this->state->setModel ($f);

		$output = $this->state->getOutput();
		$this->assertEquals(file_get_contents(VSC_FIXTURE_PATH . 'templates/' . $t), $output);
	}

	public function testGetUriParser() {
		$p = $this->state->getUriParser();

		$this->assertInstanceOf('\\vsc\\infrastructure\\urls\\UrlParserA', $p);
	}

	public function testStaticGetCurrentSiteUri () {
		$this->assertEmpty(ViewA::getCurrentSiteUri());
	}
}

