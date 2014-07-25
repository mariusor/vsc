<?php
import (VSC_FIXTURE_PATH);

import ('application');
import ('controllers');
import ('processors');
import ('sitemaps');
import ('presentation');
import ('responses');
import ('requests');
import ('views');

class vscDefaultViewTest extends PHPUnit_Framework_TestCase {
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
		$this->assertEmpty($this->state->getViewFolder());
	}
}

