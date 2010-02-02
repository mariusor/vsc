<?php
/**
 * mock object for testing the abstract fooTdoA
 */
class vscTdo extends vscAccessA {
	public function __construct () {
		$this->setConnection(sqlFactory::connect('mysql'));
	}
}
