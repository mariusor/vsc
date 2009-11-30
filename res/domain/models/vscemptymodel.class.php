<?php
/**
 * @package vsc_domain
 * @subpackage models
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.11.19
 */

import ('domain/models');
class vscEmptyModel extends vscModelA {
	private $sTitle = '[null]';
	public $sContent = '[null]';

	public function setTitle ($sTitle) {
		$this->sTitle = $sTitle;
	}

	public function getTitle () {
		return $this->sTitle;
	}

	public function setContent ($sContent) {
		$this->sContent = $sContent;
	}

	public function getContent () {
		return $this->sContent;
	}
}