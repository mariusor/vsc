<?php
/**
 * @package vsc_domain
 * @subpackage access
 * @author marius orcsik <marius@habarnam.ro>
 * @date 10.04.01
 */
import ('domain/domain');
class vscSqlAccess extends vscSqlAccessA implements vscSqlAccessI {
	public function getDatabaseType() {
		throw new vscExceptionDomain('Please implement ['. __METHOD__ . '] in a child class.');
	}
	public function getDatabaseHost() {
		throw new vscExceptionDomain('Please implement ['. __METHOD__ . '] in a child class.');
	}
	public function getDatabaseUser() {
		throw new vscExceptionDomain('Please implement ['. __METHOD__ . '] in a child class.');
	}
	public function getDatabasePassword() {
		throw new vscExceptionDomain('Please implement ['. __METHOD__ . '] in a child class.');
	}
	public function getDatabaseName() {
		throw new vscExceptionDomain('Please implement ['. __METHOD__ . '] in a child class.');
	}

	/**
	 * (non-PHPdoc)
	 * @see lib/domain/access/vscSqlAccessI#save()
	 */
	public function save (vscDomainObjectA $oDomainObject) {
		$bInsert = false;
		$oPk = $oDomainObject->getPrimaryKey();
		foreach ($oPk->getFields() as $oField) {
			if (!$oField->hasValue()) {
				$bInsert = true;
				break;
			}
		}

		if ($bInsert) {
			$this->insert ($oDomainObject);
		} else {
			$this->update ($oDomainObject);
		}
	}

	/**
	 * (non-PHPdoc)
	 * @see lib/domain/access/vscSqlAccessI#insert()
	 */
	public function insert (vscDomainObjectA $oDomainObject) {
		return $this->getConnection()->query($this->outputInsertSql($oDomainObject));
	}

	/**
	 * (non-PHPdoc)
	 * @see lib/domain/access/vscSqlAccessI#update()
	 */
	public function update (vscDomainObjectA $oDomainObject) {
		return $this->getConnection()->query($this->outputUpdateSql($oDomainObject));
	}

	/**
	 * (non-PHPdoc)
	 * @see lib/domain/access/vscSqlAccessI#delete()
	 */
	public function delete (vscDomainObjectA $oDomainObject) {
		return $this->getConnection()->query($this->outputDeleteSql($oDomainObject));
	}
}
