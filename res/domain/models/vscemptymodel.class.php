<?php
/**
 * @package vsc_domain
 * @subpackage models
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.11.19
 */

import ('domain/models');
class vscEmptyModel extends vscModelA {
	protected $sTitle = '[null]';
	protected $sContent = '[null]';

	public function setTitle ($sTitle) {
		$this->sTitle = $sTitle;
	}

	public function getTitle () {
		return $this->sTitle;
	}

	public function setContent ($sContent) {
		$this->sContent = htmlentities($sContent, null, 'UTF-8');
	}

	public function getContent () {
		return $this->sContent;
	}
}