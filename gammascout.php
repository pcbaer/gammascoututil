<?php

include 'database.php';
include 'parser.php';

$xml = '';
if ($argc <= 1) {
	$xml = fread(STDIN, 1 * 1000 * 1000 * 1000);
} else {
	$xml = file_get_contents($argv[1]);
}

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

?>