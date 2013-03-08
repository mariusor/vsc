<?php
/* @var $this vscJsonView */
$e = $model->getException();

$error = array (
	'message' => $e->getCode() . ' ' . $e->getMessage(),
);

echo $this->outputModel($model);