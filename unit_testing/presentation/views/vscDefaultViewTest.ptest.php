<?php
// \vsc\import (VSC_FIXTURE_PATH);

// \vsc\import ('application');
// \vsc\import ('controllers');
// \vsc\import ('processors');
// \vsc\import ('sitemaps');
// \vsc\import ('presentation');
// \vsc\import ('responses');
// \vsc\import ('requests');
// \vsc\import ('views');

class vscDefaultViewTest extends \PHPUnit_Framework_TestCase {
	/**
	 * @var vscViewA
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
			$this->assertInstanceOf('vscExceptionPath', $e);
		}

		$this->assertEmpty($this->state->getMainTemplate());
	}

	public function testGetTemplateEmpty () {
		$path = $this->state->getTemplate();
		$this->assertEmpty($path);
	}

	public function testSetTemplate () {
		$oMap = new vscProcessorMap(__FILE__, '\A.*\Z');

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
			$this->assertInstanceOf('vscExceptionPath', $e);
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
			$this->assertInstanceOf('vscExceptionView', $e);
		}

		$f = new vscModelFixture();
		$this->state->setModel ($f);

		$m = $this->state->getModel();

		$this->assertInstanceOf('vscModelA', $m);
		$this->assertInstanceOf('vscModelFixture', $m);
		$this->assertEquals($f, $m);
	}

	public function testGetTitleFromMap() {
		try {
			$this->assertEmpty ( $this->state->getTitle () );
		} catch (Exception $e) {
			// catching a model exception
		}
		$oMap = new vscProcessorMap(__FILE__, '\A.*\Z');

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

		$oMap = new vscProcessorMap(__FILE__, '\A.*\Z');

		$oMap->setTemplatePath(VSC_FIXTURE_PATH . 'templates/');
		$oMap->setTemplate('main.tpl.php');

		$this->state->setMap($oMap);
		$f = new vscEmptyModel();
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
			$this->assertInstanceOf ('vscExceptionPath', $e);
		}

		$t = 'main.tpl.php';
		$oMap = new vscProcessorMap(__FILE__, '\A.*\Z');

		$oMap->setTemplatePath(VSC_FIXTURE_PATH . 'templates/');
		$oMap->setTemplate($t);

		$this->state->setMap($oMap);

		$f = new vscModelFixture();
		$this->state->setModel ($f);

		$output = $this->state->fetch($t);
		$this->assertEquals(file_get_contents(VSC_FIXTURE_PATH . 'templates/' . $t), $output);
	}

	public function testGetOutput() {
		try {
			$this->state->getOutput();
		} catch (Exception $e) {
			$this->assertInstanceOf ('vscExceptionView', $e);
		}

		$t = 'main.tpl.php';
		$oMap = new vscProcessorMap(__FILE__, '\A.*\Z');
		$oMap->setTemplatePath(VSC_FIXTURE_PATH . 'templates/');
		$oMap->setTemplate($t);

		$this->state->setMap($oMap);

		$f = new vscModelFixture();
		$this->state->setModel ($f);

		$output = $this->state->getOutput();
		$this->assertEquals(file_get_contents(VSC_FIXTURE_PATH . 'templates/' . $t), $output);
	}

	public function testGetUriParser() {
		$p = $this->state->getUriParser();

		$this->assertInstanceOf('vscUrlParserA', $p);
	}

	public function testStaticGetCurrentSiteUri () {
		$this->assertEmpty(vscViewA::getCurrentSiteUri());
	}
}

