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
	private $sMainTemplate;

//	private $sBody;

	public function getTitle () {
		return $this->sTitle;
	}

	public function setModel (vscModelA $oModel) {
		$this->oModel = $oModel;
//		if ($oModel->getTitle()) {
//			$this->sTitle = $oModel->getTitle();
//		}
	}

	public function __get ($sVarName) {
		// TODO: use proper reflection
		return $this->getModel()->$sVarName;
	}

	/**
	 * @return vscModelA
	 */
	public function getModel () {
		return $this->oModel;
	}

//	public function setBody ($sText) {
//		$this->sBody = $sText;
//	}

	public function fetch ($includePath) {
		if (empty($includePath))
			return '';
		ob_start ();
		if (is_file ($includePath)) {
			$bIncluded = include ($includePath);
		} else {
			ob_end_clean();
			throw new vscExceptionPackageImport ('Template [' . $includePath . '] could not be located');
		}
		$sContent = ob_get_contents();
		ob_end_clean ();
		return $sContent;
	}

	abstract public function getOutput ();

	public function getTemplate() {
		return $this->sMainTemplate;
	}

	public function setTemplate($sPath) {
		$this->sMainTemplate = $sPath;
	}
}
