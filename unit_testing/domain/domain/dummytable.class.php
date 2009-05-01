<?php
usingPackage ('models/foo');

class dummyTable extends fooEntityA {
	protected $_name = 'dummy';

	public $id;
	public $payload;
	public $timestamp;

	public function __construct () {
		$this->id 		= new fooFieldInteger('id');
		$this->id->setAutoIncrement (true);

		$this->payload 		= new fooFieldVarChar ('payload');
		$this->timestamp 	= new fooFieldDateTime ('ts');

		$this->setPrimaryKey ($this->id);
	}
}