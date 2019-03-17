#!/bin/bash

file="xml/GammaScout_$(date +%Y-%m-%d).xml"
util="util/gammascoututil"
import="php gammascout.php"

if [ -z "$GAMMA_SCOUT_USB" ]
then
	echo "Searching USB interfaces for a Gamma Scout device..."
	for USB in /dev/ttyUSB*
	do
		echo "Trying $USB..."
		$util -d $USB identify 2> /dev/null | grep "Log buffer fill" > /dev/null
		if [ $? -eq 0 ]
		then
			GAMMA_SCOUT_USB=$USB
			break
		fi
	done
	if [ -z "$GAMMA_SCOUT_USB" ]
	then
		echo "Error: Could not find a Gamma Scout device on any USB interface!"
		exit 1
	fi
fi

echo "Identifying the Gamma Scout device..."
$util -d $GAMMA_SCOUT_USB identify

echo "Read all data..."
$util -d $GAMMA_SCOUT_USB readlog:xml:$file clearlog syncutctime

echo "Import into database..."
$import $file
