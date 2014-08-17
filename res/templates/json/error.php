<?php
/* @var \vsc\domain\models\ErrorModel $model */
/* @var $this \vsc\presentation\views\JsonView */
use \vsc\infrastructure\vsc;

$e = $model->getException();
$error = array (
	'message' => $e->getCode() . ' ' . $e->getMessage(),
);

if (vsc::getEnv()->isDevelopment()) {
	$error['location'] = $e->getFile().':'.$e->getLine();
	$error['trace'] = $e->getTrace();
}

echo $this->outputModel ($error);
