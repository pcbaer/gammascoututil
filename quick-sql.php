<?php

include 'parser.php';

$xml    = file_get_contents('php://stdin');
$parser = new GammaScout\Parser($xml);

while (true) {
	$row = $parser->getNext();
	if ($row === null) {
		break;
	}

	$from   = DateTime::createFromFormat('Y-m-d H:i:s', $row[0], new DateTimeZone('UTC'));
	$to     = DateTime::createFromFormat('Y-m-d H:i:s', $row[1], new DateTimeZone('UTC'));
	$counts = $row[2];
	if (!$from || !$to) {
		fwrite(STDERR, 'Could not parse date format, aborting!');
		exit(1);
	}
	$seconds = $to->getTimestamp() - $from->getTimestamp();
	if ($seconds < 60) {
		fwrite(STDERR, 'Unexpected interval ' . $seconds . 's, aborting!');
		var_dump($row);
		exit(1);
	}

	$time   = $from->format('Y-m-d H') . ':00:00';
	$dosage = $counts / (142 * $seconds / 60);
	echo "INSERT IGNORE INTO `gammascout` (`time`, `dosage`) VALUES ('" . $time . "', " . $dosage . ");" . PHP_EOL;
}
