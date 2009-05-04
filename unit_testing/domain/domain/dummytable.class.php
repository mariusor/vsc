<?php
usingPackage ('models/foo');

class dummyTable extends fooEntityA {
	protected $_name = 'dummy2';

	public $id;
	private $payload;
	public $timestamp;

	public function __construct () {
		$this->id 		= new fooFieldInteger('id');
		$this->id->setAutoIncrement (true);

		$this->payload 		= new fooFieldVarChar ('payload');
		$this->timestamp 	= new fooFieldDateTime ('ts');

		$this->setPayload(2);

		$this->setPrimaryKey ($this->id, $this->payload);
	}

	public function setId ($iId) {}
	public function setPayload ($sPayload) {}
	public function setTimestamp ($sDate) {}

	public function getId () {}
	public function getPayload () {}
	public function getTimestamp () {}
}