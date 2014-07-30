<?php
/* @var \vsc\domain\models\vscErrorModel $model */
/* @var $this \vsc\presentation\views\vscJsonView */
use vsc\infrastructure\vsc;

$e = $model->getException();
$error = array (
	'message' => $e->getCode() . ' ' . $e->getMessage(),
);

if (vsc::getEnv()->isDevelopment()) {
	$error['location'] = $e->getFile().':'.$e->getLine();
	$error['trace'] = $e->getTrace();
}

echo $this->outputModel ($error);
