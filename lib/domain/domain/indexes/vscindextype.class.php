<?php
interface vscIndexType {
	const INDEX		= 1;
	const UNIQUE	= 2;
	const PRIMARY	= 3; // INDEX | UNIQUE
	const FULLTEXT	= 4;
}