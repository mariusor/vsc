<?php
interface vscConnectionType {
	const nullsql		= -1;
	const mysql			= 1;
	const postgresql	= 2;
	const sqlite		= 3;
	const mssql			= 4;
}