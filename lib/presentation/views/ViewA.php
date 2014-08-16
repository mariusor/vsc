<?php
/**
 * @package presentation
 * @subpackage views
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.08.30
 */
namespace vsc\presentation\views;

use vsc\application\sitemaps\MappingA;
use vsc\application\sitemaps\ProcessorMap;
use vsc\domain\models\EmptyModel;
use vsc\domain\models\HttpModelI;
use vsc\domain\models\ModelA;
use vsc\infrastructure\urls\UrlParserA;
use vsc\infrastructure\urls\UrlRWParser;
use vsc\infrastructure\vsc;
use vsc\infrastructure\Null;
use vsc\infrastructure\Object;
use vsc\presentation\helpers\ViewHelperA;
use vsc\ExceptionPath;

abstract class ViewA extends Object implements ViewI {
	/**
	 * @var string
	 */
	private $sTitle;

	/**
	 * @var ModelA
	 */
	private $oModel;

	/**
	 * @var ViewHelperA[]
	 */
	private $aHelpers = array();

	/**
	 * @var string
	 */
	private $sMainTemplate;

	/**
	 * @var ProcessorMap
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
	 * @var UrlParserA
	 */
	static private $oUriParser;

	/**
	 * @param $sPath
	 * @throws ExceptionPath
	 */
	public function setMainTemplate ($sPath) {
		if ( !is_file($sPath) ) {
			throw new ExceptionPath('The main template [' . $sPath . '] is not accessible.');
		}

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
	 * @throws ExceptionView
	 */
	public function getTitle () {
		try {
			/** @var EmptyModel $oModel */
			$oModel = $this->getModel();
			if (($oModel instanceof HttpModelI) && $oModel->getPageTitle() != '') {
				return  $oModel->getPageTitle();
			}
		} catch (\Exception $e) {
			//
		}

		$sStaticTitle	= $this->getMap()->getTitle();
		if (!empty ($sStaticTitle)) return $sStaticTitle;

		return $this->sTitle;
	}

	/**
	 * @param ModelA $oModel
	 */
	public function setModel (ModelA $oModel) {
		$this->oModel = $oModel;
	}

	/**
	 * @throws ExceptionView
	 * @returns ProcessorMap
	 */
	public function getMap () {
		if (MappingA::isValid($this->oCurrentMap)) {
			return $this->oCurrentMap;
		} else {
			throw new ExceptionView ('Make sure the current map is correctly set.');
		}
	}

	/**
	 * @param MappingA $oMap
	 */
	public function setMap ($oMap) {
		$this->oCurrentMap = $oMap;
	}

	public function registerHelper (ViewHelperA $oHelper) {
		$this->getMap()->registerHelper( $oHelper ) ;
	}

	public function __call ($sMethodName, $aParameters = array()) {
		// to be used with helpers
		foreach ($this->getMap()->getViewHelpers() as $key => $oHelper) {
			$oReflection = new \ReflectionClass ($oHelper);
			if ($oReflection->hasMethod($sMethodName)) {
				$oMethod = $oReflection->getMethod($sMethodName);
				return $oMethod->invokeArgs($oHelper, $aParameters);
			}
		}
		return $aParameters;
	}

	/**
	 * @param $sVarName
	 * @return void|Null
	 */
	public function __get ($sVarName) {
		try {
		// TODO: use proper reflection
			return $this->getModel()->$sVarName;
		} catch (\Exception $e) {
			// most likely the variable doesn't exist
			\vsc\d ($e->getTraceAsString());
		}
	}

	/**
	 * @throws ExceptionView
	 * @returns ModelA
	 */
	public function getModel () {
		if (ModelA::isValid($this->oModel)) {
			return $this->oModel;
		} else {
			return new Null();
		}
	}

//	public function setBody ($sText) {
//		$this->sBody = $sText;
//	}

	/**
	 * @param string $includePath
	 * @return string
	 * @throws ExceptionPath
	 * @throws ExceptionView
	 */
	public function fetch ($includePath) {
		if (empty($includePath)) {
			throw new ExceptionPath ('Template [' . $includePath . '] could not be located');
		}

		ob_start ();
		if (!is_file ($includePath)) {
			$includePath = $this->getTemplatePath() . $includePath;
			if (!is_file ($includePath)) {
				ob_end_clean();
				throw new ExceptionPath ('Template [' . $includePath . '] could not be located');
			}
		}
		$bIncluded = false;
		// outputting the model's content into the local scope
		$model = $this->getModel();
		extract(
			array(
				'model' 	=> $model,
				'view'		=> $this,
				'helper'	=> $this->getMap(),
				'request'	=> vsc::getEnv()->getHttpRequest()
			),
			EXTR_SKIP
		);

		try {
			$bIncluded = include ($includePath);
		} catch (\ErrorException $ee) {

		} catch (\Exception $e) {

		}

		if (!$bIncluded) {
			ob_end_clean();
			throw new ExceptionView ('Template [' . $includePath . '] could not be included');
		} else {
			$sContent = ob_get_contents();
			ob_end_clean();
			return $sContent;
		}
	}

	/**
	 * @return string
	 * @throws ExceptionView
	 */
	public function getOutput() {
		try {
			// by default try to load the main template
			return $this->fetch ( $this->getMainTemplate() );
		} catch (ExceptionPath $e) {
			// if it fails, we load the regular template.
			try {
				return $this->fetch ($this->getTemplatePath() . DIRECTORY_SEPARATOR . $this->getMap()->getTemplate());
			} catch (ExceptionPath $e) {
				return '';
			}
		}
	}

	/**
	 * @return string
	 * @throws ExceptionView
	 */
	public function getTemplatePath() {
		$sTemplatePath = $this->getMap()->getTemplatePath();
		$sViewFolder = $this->getViewFolder();

		if (!empty($sViewFolder)) {
			$sTemplatePath .= DIRECTORY_SEPARATOR . $sViewFolder;
		}

		if (!UrlRWParser::hasGoodTermination($sTemplatePath, DIRECTORY_SEPARATOR)) {
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
		} catch (ExceptionView $e) {
			return '';
		}
	}

	/**
	 * @param string $sPath
	 */
	public function setTemplate($sPath) {
		try {
			$this->getMap()->setTemplate($sPath);
		} catch (ExceptionView $e) {
			//
		}
	}

	/**
	 * @returns UrlRWParser
	 */
	static public function getUriParser () {
		if (!UrlParserA::isValid(self::$oUriParser)) {
			self::$oUriParser = new UrlRWParser();
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
		return htmlspecialchars(vsc::getEnv()->getHttpRequest()->getUri(true));
	}

	/**
	 * @param int $iParent
	 * @return string
	 */
	static public function getParentUri ($iParent = 1) {
		return htmlspecialchars(self::getUriParser()->getCompleteParentUri(true, $iParent));
	}
}
