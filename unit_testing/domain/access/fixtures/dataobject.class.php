<?php
/**
 * mock object for testing the abstract fooTdoA
 */
class fooTdo extends fooTdoA {
	public function __construct () {
		$this->setConnection(sqlFactory::connect('mysql'));
	}
}
