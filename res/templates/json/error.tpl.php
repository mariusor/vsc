<?php
/* @var $model vscErrorModel */
$t = array();
if (vscExceptionResponseError::isValid($model->getException())) {
	$t['error_code'] = $model->getException()->getErrorCode();
//	$t['error_message'] = $model->getException()->getErrorMessage();
}
$t['message'] = $model->getMessage();
/* @var $this vscJsonView */
echo $this->outputModel($t);
