<?php
/**
 * @package domain
 * @subpackage models
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.11.19
 */
namespace vsc\domain\models;

class EmptyModel extends ModelA implements HttpModelInterface {
	protected $sPageTitle = null;
	protected $sPageContent = null;

	public function setPageTitle($sTitle) {
		$this->sPageTitle = $sTitle;
	}

	public function getPageTitle() {
		return $this->sPageTitle;
	}

	public function setPageContent($sContent) {
		$this->sPageContent = $sContent;
	}

	public function getPageContent() {
		return $this->sPageContent;
	}
}
