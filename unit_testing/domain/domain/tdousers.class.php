<?php
usingPackage ('models/foo');
class tdoUsers extends fooEntityA {
	protected $_name = 'users';

	private $id;
	private $userName;
	private $userEmail;
	private $userCredentials;
	private $userActive;

	public function __construct () {}
}