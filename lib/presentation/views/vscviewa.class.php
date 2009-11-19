<?php
/**
 * @package vsc_presentation
 * @subpackage views
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.08.30
 */
abstract class vscViewA implements vscViewI {
	private $sTitle;
	private $oModel;

	public function getTitle () {
		return $this->sTitle;
	}

	public function setModel (vscModelI $oModel) {
		$this->oModel = $oModel;
		if ($oModel->sTitle)
			$this->sTitle = $oModel->sTitle;
	}

	public function getModel () {
		return $this->oModel;
	}

	public function setContent ($sText) {
		$this->sContent = $sText;
	}

	public function getContent () {
		return $this->oModel->sContent;
	}

	public function fetch ($includePath) {
		ob_start ();
		if (is_file ($includePath)) {
			$bIncluded = @include ($includePath);
		} else {
			ob_end_clean();
			throw new vscExceptionPackageImport ('Template ' . $includePath . ' could not be located');
			return '';
		}

		$this->sContent = ob_get_contents();
		ob_end_clean ();
		return $this->sContent;
	}

	public function getOutput () {
		return $this->fetch(VSC_RES_PATH . 'templates' . DIRECTORY_SEPARATOR . 'xhtml/main.php');
	}
}
