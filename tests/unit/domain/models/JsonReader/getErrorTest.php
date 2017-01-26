<?php
namespace res\domain\models\JsonReader;
use vsc\domain\models\JsonReader;

/**
 * Class getErrorTest
 * @package res\domain\models\JsonReader
 * @covers \vsc\domain\models\JsonReader::getError()
 */
class getErrorTest extends \BaseUnitTest
{

	public function providerJsonErrorCode()
	{
		return [
			'max_stack' => [JSON_ERROR_DEPTH, 'Maximum stack depth exceeded'],
			'unexpected_ctrl_char' => [JSON_ERROR_CTRL_CHAR, 'Unexpected control character found'],
			'malformed_json' => [JSON_ERROR_SYNTAX, 'Syntax error, malformed JSON'],
			'ok' => [JSON_ERROR_NONE, 'No errors'],
			'to do' => [JSON_ERROR_STATE_MISMATCH, 'No errors'], // @TODO
			'to do' => [JSON_ERROR_CTRL_CHAR, 'No errors'], // @TODO
			'to do' => [JSON_ERROR_UTF8, 'No errors'], // @TODO
			'to do' => [JSON_ERROR_RECURSION, 'No errors'], // @TODO
			'to do' => [JSON_ERROR_INF_OR_NAN, 'No errors'], // @TODO
			'to do' => [JSON_ERROR_UNSUPPORTED_TYPE, 'No errors'], // @TODO
		];
	}

	/**
	 * @param $errCode
	 * @param $errString
	 * @dataProvider providerJsonErrorCode
	 */
	public function testBasicGetError($errCode, $errString)
	{
		$this->assertEquals($errString, JsonReader::getError($errCode));
	}
}
