<?php
/**
 * this will be linked from the snaptest/addons folder
 */
$config['name'] = 'VSC v.2';
$config['version'] = '0.1';
$config['author'] = 'marius orcsik <marius@habarnam.ro>';
$config['description'] = 'VSC v.2 configuration for UnitTesting';
include_once ('core/reporter/reporter.php');
include_once ('core/reporter/reporters/text.php');
include_once ('core/reporter/reporters/phpserializer.php');

set_include_path (realpath ('../vsc-v.2/') . PATH_SEPARATOR . get_include_path());
require ('vsc.inc.php');

error_reporting(-1);
ini_set('display_errors', 1);
