<?php
interface vscJoinType {
	const INNER = 0;
	const OUTER = 1;
	const LEFT	= 3; // LEFT | OUTER = true
	const RIGHT	= 5; // RIGHT | OUTER = true
}