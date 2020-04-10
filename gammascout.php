<?php

include 'database.php';
include 'parser.php';

$xml      = file_get_contents($argc <= 1 ? 'php://stdin' : $argv[1]);
$parser   = new GammaScout\Parser($xml);
$database = new GammaScout\Database();

$rows     = array();
while (true) {
	$row = $parser->getNext();
	if ($row === null) {
		break;
	}
	$rows[] = $row;
}
echo count($rows) . ' lines parsed.' . PHP_EOL;

$database->insert($rows);
echo 'Import finished.' . PHP_EOL;
