<?php
/* @var $this vscJsonView */
$e = $model->getException();
$error = array (
	'message' => $e->getCode() . ' ' . $e->getMessage(),
);
if (vsc::getEnv()->isDevelopment()) {
	$error['location'] = $e->getFile().':'.$e->getLine();
	$error['trace'] = $e->getTrace();
}
echo $this->outputModel($model);
