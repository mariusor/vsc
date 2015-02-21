<?php
/* @var \vsc\domain\models\ErrorModel $model */
/* @var $this \vsc\presentation\views\JsonView */
$e = $model->getException();

$error = array(
	'message' => $e->getCode().' '.$e->getMessage(),
);

echo $this->outputModel($model);
