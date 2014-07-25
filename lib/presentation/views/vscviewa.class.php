<?php
/**
 * @package vsc_presentation
 * @subpackage views
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.08.30
 */
import ('infrastructure');
import ('urls');

abstract class vscViewA extends vscObject implements vscViewI {
	/**
	 * @var string
	 */
	private $sTitle;

	/**
	 * @var vscModelA
	 */
	private $oModel;

	/**
	 * @var vscViewHelperA[]
	 */
	private $aHelpers = array();

	/**
	 * @var string
	 */
	private $sMainTemplate;

	/**
	 * @var vscProcessorMap
	 */
	private $oCurrentMap;

	/**
	 * type of view (html, rss, etc)
	 * @var string
	 */
	protected $sContentType;

	/**
	 * @var string
	 */
	protected $sFolder;

	/**
	 * @var vscUrlParserA
	 */
	static private $oUriParser;

	/**
	 * @param $sPath
	 * @throws vscExceptionPath
	 */
	public function setMainTemplate ($sPath) {
		if (!is_file($sPath))
			throw new vscExceptionPath('The main template ['.$sPath.'] is not accessible.');

		$this->sMainTemplate = $sPath;
	}

	/**
	 * @return string
	 */
	public function getMainTemplate () {
		return $this->sMainTemplate;
	}

	/**
	 * @return string
	 */
	public function getContentType() {
		return $this->sContentType;
	}

	/**
	 * @return string
	 */
	public function getViewFolder() {
		return $this->sFolder;
	}

	/**
	 * @return string
	 * @throws vscExceptionView
	 */
	public function getTitle () {
		try {
			if ($this->getModel()->getPageTitle() != '') {
				return  $this->getModel()->getPageTitle();
			}
		} catch (Exception $e) {
			//
		}

		$sStaticTitle	= $this->getMap()->getTitle();
		if (!empty ($sStaticTitle)) return $sStaticTitle;

		return $this->sTitle;
	}

	/**
	 * @param vscModelA $oModel
	 */
	public function setModel (vscModelA $oModel) {
		$this->oModel = $oModel;
	}

	/**
	 * @throws vscExceptionView
	 * @return vscProcessorMap
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

	public function registerHelper (vscViewHelperA $oHelper) {
		$this->getMap()->registerHelper( $oHelper ) ;
	}

	public function __call ($sMethodName, $aParameters = array()) {
		// to be used with helpers
		foreach ($this->getMap()->getViewHelpers() as $key => $oHelper) {
			$oReflection = new ReflectionClass ($oHelper);
			if ($oReflection->hasMethod($sMethodName)) {
				$oMethod = $oReflection->getMethod($sMethodName);
				return $oMethod->invokeArgs($oHelper, $aParameters);
			}
		}
		return $aParameters;
	}

	/**
	 * @param $sVarName
	 * @return void|vscNull
	 */
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
	 * @throws vscExceptionView
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

	/**
	 * @param string $includePath
	 * @return string
	 * @throws vscExceptionPath
	 * @throws vscExceptionView
	 */
	public function fetch ($includePath) {
		if (empty($includePath)) {
			throw new vscExceptionPath ('Template [' . $includePath . '] could not be located');
		}

		ob_start ();
		if (!is_file ($includePath)) {
			$includePath = $this->getTemplatePath() . $includePath;
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
				'request'	=> vsc::getEnv()->getHttpRequest()
			),
			EXTR_SKIP
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

	/**
	 * @return string
	 * @throws vscExceptionView
	 */
	public function getOutput() {
		try {
			// by default try to load the main template
			return $this->fetch ( $this->getMainTemplate() );
		} catch (vscExceptionPath $e) {
			// if it fails, we load the regular template.
			try {
				return $this->fetch ($this->getTemplatePath() . DIRECTORY_SEPARATOR . $this->getMap()->getTemplate());
			} catch (vscExceptionPath $e) {
				return '';
			}
		}
	}

	/**
	 * @return string
	 * @throws vscExceptionView
	 */
	public function getTemplatePath() {
		$sTemplatePath = $this->getMap()->getTemplatePath();
		$sViewFolder = $this->getViewFolder();

		if (!empty($sViewFolder)) {
			$sTemplatePath .= DIRECTORY_SEPARATOR . $sViewFolder;
		}

		if (!vscUrlRWParser::hasGoodTermination($sTemplatePath, DIRECTORY_SEPARATOR)) {
			$sTemplatePath .= DIRECTORY_SEPARATOR;
		}
		return $sTemplatePath;
	}

	/**
	 * @return string
	 */
	public function getTemplate() {
		try {
			return $this->getMap()->getTemplate();
		} catch (vscExceptionView $e) {
			return '';
		}
	}

	/**
	 * @param string $sPath
	 */
	public function setTemplate($sPath) {
		try {
			$this->getMap()->setTemplate($sPath);
		} catch (vscExceptionView $e) {
			//
		}
	}

	/**
	 * @return vscUrlRWParser
	 */
	static public function getUriParser () {
		if (!vscUrlParserA::isValid(self::$oUriParser)) {
			self::$oUriParser = new vscUrlRWParser();
		}
		return self::$oUriParser;
	}

	/**
	 * @return string
	 */
	static public function getCurrentSiteUri () {
		return htmlspecialchars(self::getUriParser()->getSiteUri());
	}

	/**
	 * @return string
	 */
	static public function getCurrentUri() {
		return htmlspecialchars(self::getUriParser()->getCompleteUri(true));
	}

	/**
	 * @param int $iParent
	 * @return string
	 */
	static public function getParentUri ($iParent = 1) {
		return htmlspecialchars(self::getUriParser()->getCompleteParentUri(true, $iParent));
	}
}
