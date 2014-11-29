<?php

/* @var $this \vsc\application\sitemaps\RwSiteMap */
$this->getCurrentModuleMap()->setTemplatePath(VSC_FIXTURE_PATH . 'templates' . DIRECTORY_SEPARATOR );
$oMap = $this->map ('test', \fixtures\application\processors\ProcessorFixture::class);
$oMap->mapController('.*', \fixtures\application\controllers\GenericFrontController::class);

