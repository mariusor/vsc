<?php
$e = $model->getException();
$error = array (
	'message' => $e->getCode() . ' ' . $e->getMessage(),
);
if (vsc::getEnv()->isDevelopment()) {
	$error['location'] = $e->getFile().':'.$e->getLine();
	$error['trace'] = $e->getTrace();
}
echo json_encode ($error, JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | (isDebug() ? JSON_PRETTY_PRINT : 0) | (isDebug() ?  JSON_UNESCAPED_SLASHES : 0) );
