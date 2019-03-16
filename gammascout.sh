#!/bin/bash

file="xml/GammaScout_$(date +%Y-%m-%d).xml"
util="util/gammascoututil"
import="php gammascout.php"

echo Identifying the Gamma Scout device...
$util identify
echo Read all data...
$util readlog:xml:$file
echo Import...
$import $file
