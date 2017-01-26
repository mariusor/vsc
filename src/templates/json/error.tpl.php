<?php
use vsc\presentation\responses\ExceptionResponseError;
/* @var $model \vsc\domain\models\ErrorModel */
$t = array();
if (ExceptionResponseError::isValid($model->getException())) {
	$t['error_code'] = $model->getException()->getErrorCode();
//	$t['error_message'] = $model->getException()->getErrorMessage();
}
$t['message'] = $model->getMessage();
/* @var $this \vsc\presentation\views\JsonView */
echo $this->outputModel($t);
