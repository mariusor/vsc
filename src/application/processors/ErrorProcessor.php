<?php
/**
 * @package presentation
 * @subpackage processors
 * @author marius orcsik <marius@habarnam.ro>
 * @date 11.05.17
 */
namespace vsc\application\processors;

use vsc\application\sitemaps\ErrorProcessorMap;
use vsc\domain\models\EmptyModel;
use vsc\domain\models\ErrorModel;
use vsc\presentation\requests\HttpRequestA;
use vsc\presentation\responses\ExceptionResponseError;

class ErrorProcessor extends ProcessorA implements ErrorProcessorInterface {
	/**
	 * @var ErrorModel
	 */
	private $model;

	public function getErrorCode() {
		/** @var ErrorModel $oErrorModel */
		$oErrorModel = $this->getModel();
		$e = $oErrorModel->getException();
		if ($e instanceof ExceptionResponseError) {
			return $e->getCode();
		} else {
			return 500;
		}
	}

	public function __construct(\Exception $e = null) {
		if (!is_null($e)) {
			$this->setException($e);
		}

		$oErrorMap = new ErrorProcessorMap();
		$oErrorMap->setTemplatePath(VSC_SRC_PATH . 'templates');
		$oErrorMap->setTemplate('error.tpl.php');

		$this->setMap($oErrorMap);
	}

	/**
	 * @return ErrorModel
	 */
	public function getModel() {
		return $this->model;
	}

	public function init() {}

	public function setException(\Exception $e = null) {
		if (!is_null($e)) {
			$this->model = new ErrorModel($e);
		} else {
			$this->model = new EmptyModel();
		}
	}

	public function handleRequest(HttpRequestA $oHttpRequest) {
		return $this->getModel();
	}
}
