<?php
import ('presentation/processors');

class vscTestProcessor extends vscProcessorA {
	public function init () {
	}

	public function handleRequest (vscHttpRequestA $oHttpRequest) {
		return 'Test Controller'. '<hr/><pre>' . var_export ($this->getLocalVars(), true) . '</pre>';
	}
}