<?php
/* @var $this \vsc\application\sitemaps\RwSiteMap */
$this->getCurrentModuleMap()->setTemplatePath(VSC_MOCK_PATH . 'templates' . DIRECTORY_SEPARATOR );

$oMap = $this->map ('test', \mocks\application\processors\ProcessorFixture::class);
$oMap->map('.*', \mocks\application\controllers\FrontControllerFixture::class);

$this->map ('fixture.css', 'static/fixture.css');

