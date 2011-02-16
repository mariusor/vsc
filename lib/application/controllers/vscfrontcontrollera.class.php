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
			throw new vscExceptionView ('Make sure the current map is correctly set.');
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
		$oResponse = null;
		$oModel = null;

		if (($oProcessor instanceof vscProcessorI)) {
			try {
				$oModel = $oProcessor->handleRequest($oRequest);
			} catch (vscExceptionResponseRedirect $e) {
				$oResponse = new vscHttpRedirection();
				$oResponse->setStatus($e->getRedirectCode());
				$oResponse->setLocation ($e->getLocation());

				return $oResponse;
			} catch (vscExceptionResponseError $e) {
				// we had error in the controller
				// @todo make more error processors
				$oProcessor = new vsc404Processor();
				$oModel = new vscEmptyModel();
				$oModel->setPageTitle('404 - Not Found');
				$oModel->setPageContent($e->getMessage());

				// hardcoding the 404 replies
				$this->getMap()->setMainTemplatePath(VSC_RES_PATH . 'templates');
				$this->getMap()->setMainTemplate('404.php');
			} catch (Exception $e) {
				throw $e;
			}
		}

		if (!($oProcessor instanceof vscErrorProcessorI)) {
			$oResponse = new vscHttpSuccess();
			$oResponse->setStatus (200);
		} else {
			$oResponse = new vscHttpClientError();
			$oResponse->setStatus($oProcessor->getErrorCode());
		}

		// we didn't set any special view
		// this means that the developer needs to provide his own views
		$oView	= $this->getDefaultView();

		/* @var $oMyMap vscControllerMap */
		$oMyMap	= $this->getMap();
		if (($oProcessor instanceof vscProcessorI)) {
			/* @var $oMap vscMappingA */
			$oMap = $oProcessor->getMap()->merge($oMyMap);
		}

		// setting the processor map
		$oView->setMap ($oMap);

		if (!$oMap->isStatic() && ($oMyMap instanceof vscContentTypeMappingI)) {
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
}
