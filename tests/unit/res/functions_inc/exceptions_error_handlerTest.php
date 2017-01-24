<?php
namespace tests\res\functions_inc;
use vsc\ExceptionError;

/**
 * Class exceptions_error_handler
 * @package tests\res\functions_inc
 */
class exceptions_error_handler extends \BaseUnitTest
{
	public function testBasicExceptionsErrorHandler()
	{
		$severity = E_USER_ERROR;
		$message = 'test';
		$file = __FILE__;
		$line = __LINE__ + 1;
		try {
			\vsc\exceptions_error_handler($severity, $message, $file, $line);
		} catch (\Exception $e) {
			$this->assertInstanceOf(ExceptionError::class, $e);
		}
	}
}
