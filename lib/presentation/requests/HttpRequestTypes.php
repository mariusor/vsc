<?php
namespace vsc\presentation\requests;

abstract class HttpRequestTypes {
	const GET		= 'GET';
	const HEAD		= 'HEAD';
	const POST		= 'POST';
	const PUT		= 'PUT';
	const DELETE	= 'DELETE';
	const TRACE     = 'TRACE';
	const OPTIONS	= 'OPTIONS';
}
