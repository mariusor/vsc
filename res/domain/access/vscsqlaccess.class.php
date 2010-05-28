<?php
/**
 * @package vsc_domain
 * @subpackage access
 * @author marius orcsik <marius@habarnam.ro>
 * @date 10.04.01
 */
import (VSC_LIB_PATH . 'domain/domain');
import (VSC_LIB_PATH . 'domain/access');
class vscSqlAccess extends vscSqlAccessA /*implements vscSqlAccessI*/ {

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
