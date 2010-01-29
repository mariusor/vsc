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

	private $oCurrentMap;

//	private $sBody;

	protected $sContentType;

	public function getContentType() {
		return $this->sContentType;
	}

	public function getTitle () {
		return $this->sTitle;
	}

	public function setModel (vscModelA $oModel) {
		$this->oModel = $oModel;
//		if ($oModel->getTitle()) {
//			$this->sTitle = $oModel->getTitle();
//		}
	}

	/**
	 * @return vscMapping
	 */
	public function getMap () {
		if ($this->oCurrentMap instanceof vscMapping) {
			return $this->oCurrentMap;
		} else {
			throw new vscExceptionView ('Make sure the current map is correctly set.');
		}
	}

	public function setMap ($oMap) {
		$this->oCurrentMap = $oMap;
	}

	public function __get ($sVarName) {
		// TODO: use proper reflection
		return $this->getModel()->$sVarName;
	}

	/**
	 * @return vscModelA
	 */
	public function getModel () {
		if ($this->oModel instanceof vscModelA) {
			return $this->oModel;
		} else {
			throw new vscExceptionView('The current model is null');
		}
	}

//	public function setBody ($sText) {
//		$this->sBody = $sText;
//	}

	public function fetch ($includePath) {
		if (empty($includePath))
			return '';
		ob_start ();
		try {
			if (is_file ($includePath)) {
				$bIncluded = require ($includePath);
			} else {
				cleanBuffers ();
				throw new vscExceptionPath ('Template [' . $includePath . '] could not be located');
			}
			$sContent = ob_get_contents();
			ob_end_clean ();
			return $sContent;
		} catch (ErrorException $e) {
			cleanBuffers();
			throw $e;
		}
	}

//	abstract public function getOutput ();

	abstract public function getTemplateFolder ();

	public function getTemplate() {
		try {
    		return $this->getMap()->getPath() . DIRECTORY_SEPARATOR . $this->getTemplateFolder() . $this->getMap()->getTemplateName();
		} catch (vscExceptionView $e) {
			return '';
		}
	}

	public function setTemplateName($sPath) {
		try {
    		$this->getMap()->setTemplateName($sPath);
		} catch (vscExceptionView $e) {
			//
		}
	}
}
