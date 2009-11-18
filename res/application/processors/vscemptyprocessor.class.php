<?php
class vscEmptyProcessor extends vscProcessorA {

	public function init () {}

	public function handleRequest (vscHttpRequestA $oHttpRequest) {
		return '<html><head><title>[ null ]</title></head><body><pre>[ NULL ]</pre></body></html>';
	}
}