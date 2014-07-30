<?php
/* @var \vsc\domain\models\vscErrorModel $model */
/* @var $this \vsc\presentation\views\vscJsonView */
$e = $model->getException();

$error = array (
	'message' => $e->getCode() . ' ' . $e->getMessage(),
);

echo $this->outputModel($error);
