<?php
import (VSC_LIB_PATH . 'domain');
import ('domain');

class dummyTable extends vscDomainObjectA {
	protected $name = 'dummy';
	public $id;
	public $payload;
	public $timestamp;

	public function buildObject() {
		$this->id 		= new vscFieldInteger('id');
		$this->id->setAutoIncrement (true);

		$this->payload 		= new vscFieldText('payload');
		$this->timestamp 	= new vscFieldDateTime ('ts');

		// this is used later in the testGetter - if you modify here, modify the vscentity.stest.php file
		$this->setPayload(2);

		$this->setPrimaryKey ($this->id);
	}
}