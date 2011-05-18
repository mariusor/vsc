<?php
/**
 * @package vsc_presentation
 * @subpackage views
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.08.30
 */
abstract class vscViewA extends vscObject implements vscViewI {
	private $sTitle;
	private $oModel;

	private $sMainTemplate;

	private $oCurrentMap;

	/**
	 * type of view (html, rss, etc)
	 * @var string
	 */
	protected $sContentType;
	protected $sFolder;

	static private $oUriParser;

	public function setMainTemplate ($sPath) {
		if (!is_file($sPath))
			throw new vscExceptionPath('The main template ['.$sPath.'] is not accessible.');

		$this->sMainTemplate = $sPath;
	}

	public function getMainTemplate () {
		return $this->sMainTemplate;
	}

	public function getContentType() {
		return $this->sContentType;
	}

	public function getViewFolder() {
		return $this->sFolder;
	}

	public function getTitle () {
		if (vscEmptyModel::isValid($this->getModel()) && $this->getModel()->getPageTitle() != '') {
			return  $this->getModel()->getPageTitle();
		}

		$sStaticTitle	= $this->getMap()->getTitle();
		if (!empty ($sStaticTitle)) return $sStaticTitle;

		return $this->sTitle;
	}

	public function setModel (vscModelA $oModel) {
		$this->oModel = $oModel;
	}

	/**
	 * @return vscMappingA
	 */
	public function getMap () {
		if (vscMappingA::isValid($this->oCurrentMap)) {
			return $this->oCurrentMap;
		} else {
			throw new vscExceptionView ('Make sure the current map is correctly set.');
		}
	}

	/**
	 * @param vscMappingA $oMap
	 */
	public function setMap ($oMap) {
		$this->oCurrentMap = $oMap;
	}

	public function __get ($sVarName) {
		try {
		// TODO: use proper reflection
			return $this->getModel()->$sVarName;
		} catch (Exception $e) {
			// most likely the variable doesn't exist
			d ($e->getTraceAsString());
		}
	}

	/**
	 * @return vscModelA
	 */
	public function getModel () {
		if (vscModelA::isValid($this->oModel)) {
			return $this->oModel;
		} else {
			throw new vscExceptionView('The current model is invalid');
		}
	}

//	public function setBody ($sText) {
//		$this->sBody = $sText;
//	}

	public function fetch ($includePath) {
		if (empty($includePath)) {
			throw new vscExceptionPath ('Template [' . $includePath . '] could not be located');
		}

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
				'helper'	=> $this->getMap(),
				'request'	=> vsc::getHttpRequest()
			)
		);

		// this automatically excludes templating errors: I'm not quite sure yet it's OK to do it
		$bIncluded = include ($includePath);

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
			// by default try to load the main template
    		return $this->fetch ( $this->getMainTemplate() );
		} catch (vscExceptionPath $e) {
			// if it fails, we load the regular template.
			try {
	    		return $this->fetch ($this->getMap()->getTemplatePath() . DIRECTORY_SEPARATOR . $this->getMap()->getTemplate());
			} catch (vscExceptionPath $e) {
				return '';
			}
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

	/**
	 * @return  vscUrlRWParser
	 */
	static public function getUriParser () {
		if (!vscUrlParserA::isValid(self::$oUriParser)) {
			self::$oUriParser = new vscUrlRWParser();
		}
		return self::$oUriParser;
	}

	static public function getCurrentSiteUri () {
		return htmlspecialchars(self::getUriParser()->getSiteUri());
	}

	static public function getCurrentUri() {
		return htmlspecialchars(self::getUriParser()->getCompleteUri(true));
	}

	static public function getParentUri ($iParent = 1) {
		return htmlspecialchars(self::getUriParser()->getCompleteParentUri(true, $iParent));
	}
}
