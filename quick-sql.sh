#!/bin/bash

util="util/gammascoututil"
quickSql="php quick-sql.php"
tempfile=$(tempfile)

if [ -z "$GAMMA_SCOUT_USB" ]
then
	echo "Searching USB interfaces for a Gamma Scout device..." > /dev/stderr
	for USB in /dev/ttyUSB*
	do
		echo "Trying $USB..." > /dev/stderr
		$util -d $USB identify 2> /dev/null | grep "Log buffer fill" > /dev/null
		if [ $? -eq 0 ]
		then
			GAMMA_SCOUT_USB=$USB
			break
		fi
	done
	if [ -z "$GAMMA_SCOUT_USB" ]
	then
		echo "Error: Could not find a Gamma Scout device on any USB interface!" > /dev/stderr
		exit 1
	fi
fi

echo "Identifying the Gamma Scout device..." > /dev/stderr
$util -d $GAMMA_SCOUT_USB identify > /dev/stderr

echo "Read all data..." > /dev/stderr
$util -d $GAMMA_SCOUT_USB readlog:xml:$tempfile

echo "Creating sql output..." > /dev/stderr
$quickSql < $tempfile

echo "Delete temporary file $tempfile..." > /dev/stderr
rm $tempfile
