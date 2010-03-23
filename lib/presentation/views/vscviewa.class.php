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

	protected $sContentType;

	public function getContentType() {
		return $this->sContentType;
	}

	public function getTitle () {
		$sModelTitle	= $this->getModel()->getTitle();
		if (!empty ($sModelTitle)) return $sModelTitle;

		$sStaticTitle	= $this->getMap()->getTitle();
		if (!empty ($sStaticTitle)) return $sStaticTitle;

		return $this->sTitle;
	}

	public function setModel (vscModelA $oModel) {
		$this->oModel = $oModel;
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
		if (!is_file ($includePath)) {
			$includePath = $this->getMap()->getTemplatePath() . DIRECTORY_SEPARATOR . $this->getViewFolder() . DIRECTORY_SEPARATOR . $includePath;

			if (!is_file ($includePath)) {
				ob_end_clean();
				throw new vscExceptionPath ('Template [' . $includePath . '] could not be located');
			}
		}

		$bIncluded = false;
		// outputting the model's content into the local scope
		extract(
			array(
				'model' 	=> $this->getModel(),
				'view'		=> $this,
				'helper'	=> $this->getMap()
			)
		);

		// this automatically excludes templating errors: I'm not quite sure yet it's OK to do it
		$bIncluded = @include ($includePath);
		if (!$bIncluded) {
			ob_end_clean();
			throw new vscExceptionView ('Template [' . $includePath . '] could not be included');
		} else {
			$sContent = ob_get_contents();
			ob_end_clean();
			return $sContent;
		}
	}

	public function getOutput() {
		try {
    		return $this->fetch (VSC_RES_PATH . 'templates' . DIRECTORY_SEPARATOR . $this->getViewFolder() . DIRECTORY_SEPARATOR . 'main.php');
		} catch (vscExceptionView $e) {
			return '';
		}
    }

	public function getTemplate() {
		try {
    		return $this->getMap()->getTemplate();
		} catch (vscExceptionView $e) {
			return '';
		}
	}

	public function setTemplate($sPath) {
		try {
    		$this->getMap()->setTemplate($sPath);
		} catch (vscExceptionView $e) {
			//
		}
	}
}
