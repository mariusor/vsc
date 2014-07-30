<?php
use vsc\presentation\responses\vscExceptionResponseError;
/* @var $model \vsc\domain\models\vscErrorModel */
$t = array();
if (vscExceptionResponseError::isValid($model->getException())) {
	$t['error_code'] = $model->getException()->getErrorCode();
//	$t['error_message'] = $model->getException()->getErrorMessage();
}
$t['message'] = $model->getMessage();
/* @var $this \vsc\presentation\views\vscJsonView */
echo $this->outputModel($t);
