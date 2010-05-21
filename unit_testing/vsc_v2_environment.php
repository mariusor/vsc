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

// this file resides in <vsc_dir>/unit_tests and we require the path to <vsc_dir>
set_include_path (realpath (dirname(__FILE__) . '/../') . PATH_SEPARATOR . get_include_path());
require ('vsc.inc.php');

error_reporting(E_ALL);
ini_set('display_errors', '1');
