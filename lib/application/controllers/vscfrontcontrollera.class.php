<?php
/**
 * @package vsc_application
 * @subpackage controllers
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.08.30
 */
import (VSC_LIB_PATH . 'presentation/responses');
import (VSC_RES_PATH . 'domain/models');
abstract class vscFrontControllerA extends vscObject {
	private $oCurrentMap;
	private $oView;

	/**
	 * @return vscViewA
	 */
	abstract public function getDefaultView();

	/**
	 * @return vscControllerMap
	 */
	public function getMap () {
		if ($this->oCurrentMap instanceof vscControllerMap) {
			return $this->oCurrentMap;
		} else {
			throw new vscExceptionView ('Make sure the current Controller map is correctly set.');
		}
	}

	/**
	 * @param vscControllerMap $oMap
	 */
	public function setMap (vscControllerMap $oMap) {
		$this->oCurrentMap = $oMap;
	}

	/**
	 * @param vscHttpRequestA $oRequest
	 * @param vscProcessorA $oProcessor
	 * @param vscViewA $oView
	 * @return vscHttpResponseA
	 */
	public function getResponse (vscHttpRequestA $oRequest, $oProcessor = null) {
		$oResponse = new vscHttpGenericResponse();
		$oModel = null;
		/* @var $oMyMap vscControllerMap */
		$oMyMap	= $this->getMap();

		if (($oProcessor instanceof vscProcessorI)) {
			try {
				$oProcessor->init();

				$oModel = $oProcessor->handleRequest($oRequest);
			} catch (vscExceptionResponseRedirect $e) {
				$oResponse->setStatus($e->getRedirectCode());
				$oResponse->setLocation ($e->getLocation());

				return $oResponse;
			} catch (vscExceptionResponseError $e) {
				// we had error in the controller
				// @todo make more error processors
				$oModel = new vscEmptyModel();
				$oProcessor = new vscErrorProcessor();

				$aStatusList = $oResponse->getStatusList();
				$oModel->setPageTitle($e->getErrorCode() . ' - ' . $aStatusList[$e->getErrorCode()]);
				$oModel->setPageContent($e->getMessage());

				// hardcoding the 404 replies
				$oMyMap->setMainTemplatePath(VSC_RES_PATH . 'templates');
				$oMyMap->setMainTemplate('main.php');

				if (!$oMyMap->getTemplate()) {
					$oMyMap->setTemplatePath (VSC_RES_PATH . 'templates');
					$oMyMap->setTemplate ('404.php');
				}
			} catch (Exception $e) {
				throw $e;
			}
		}

		if (!($oProcessor instanceof vscErrorProcessorI)) {
			$oResponse->setStatus (200);
		} else {
			$oResponse->setStatus($oProcessor->getErrorCode());
		}

		// we didn't set any special view
		// this means that the developer needs to provide his own views
		$oView	= $this->getView();

		if (($oProcessor instanceof vscProcessorA) && !($oProcessor instanceof vsc404Processor)) {
			/* @var $oMap vscProcessorMap */
			$oMap = $oProcessor->getMap();
			$oMap->merge($oMyMap);
			$oProcessorResponse = $oMap->getResponse();

			if ($oProcessorResponse instanceof vscHttpResponseA) {
				$oResponse = $oProcessorResponse;
			}

			// setting the processor map
			$oView->setMap ($oMap);
		}

		if ((($oMap instanceof vscProcessorMap) && !$oMap->isStatic()) || ($oMyMap instanceof vscControllerMap)) {
			$oView->setMainTemplate($oMyMap->getMainTemplatePath() . DIRECTORY_SEPARATOR . $oView->getViewFolder() . DIRECTORY_SEPARATOR . $oMyMap->getMainTemplate());
		}

		if (!($oModel instanceof vscModelA)) {
			$oModel = new vscEmptyModel();
			if (!($oMap->getTitle())) {
				$oModel->setPageTitle ('Warning');
			}
			$oModel->setPageContent ('Warning: the processor didn\'t return a valid model. This is probably an error');
		}
		$oView->setModel($oModel);

		$oResponse->setView ($oView);
		return $oResponse;
	}

	public function setTemplatePath ($sIncPath) {
		if (is_dir($sIncPath)) {
			$this->sTemplatePath = $sIncPath;
		} else {
			throw new vscExceptionController('The template path ['.$sIncPath.'] is not a valid folder.');
		}
	}

	public function getView () {
		$sViewPath = $this->getMap()->getViewPath();
		if (!($this->oView instanceof vscViewA)) {
			if (is_null($sViewPath)) {
				$this->oView = $this->getDefaultView();
			} else {
				//$sViewPath	= dirname($sViewPath);
				include ($sViewPath);

				$sClassName	= vscSiteMapA::getClassName($sViewPath);

				if (!empty($sClassName)) {
					$this->oView = new $sClassName();
				}
			}
		}
		return $this->oView;
	}
}
