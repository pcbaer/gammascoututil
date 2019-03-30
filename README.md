# GammaScout

GammaScout is a fork of Johannes Bauer's GammaScoutUtil (Python) enriched with
Shell and PHP scripts by Sascha Ternes to simplify reading out measurement data
from Gamma Scout Geiger counters and write them in a MySQL database.

## License

GNU GPL v3.

## Setup

To create a MySQL database you can use _database.sql_.

The log data table is created with _tables.sql_.

## gammascout.sh

This shell script will identify a Gamma Scout and read out all log data.
Data is saved to an XML file and then imported into the database.
Log data memory on the device is cleared and time is set to UTC.

### Usage

Plug in your Gamma Scout Geiger counter and start the shell skript.

gammascout.sh can detect which USB interface the Geiger counter is connected to.

    ./gammascout.sh

You can set GAMMA_SCOUT_USB to the USB device:

	export GAMMA_SCOUT_USB=/dev/ttyUSB1
	./gammascout.sh

## gammascout.php

This PHP script will parse one XML log file and import the data into the
MySQL database.

### Usage

    php gammascout.php <XML file>

## gammascoututil

_by Johannes Bauer_

This is an ancient project of mine, gammascoututil. It's a tool to read out
Gamma Scout Geiger counters via USB and record their radation measurements.

It's kind of abandoned by me. I wanted however to preserve the history and also
push some code that has made it through testing, but was never ever released.
The last official release is v0.04, but the release candidate that came after
(0.05alpha9) is probably also fine. There has been some more development
afterwards of which I'm entirely unsure if the code even works. So if you're
looking for something reliable, choose one of the older tags.

Most notably, 0.05 adds support for the Gamma Scout Online and some conversion
curves from counts/sec to µSv/hr.

The reverse engineered Gamma Scout protocol documentation can be found at
https://johannes-bauer.com/linux/gammascout/

### Prerequisites

Here's what's required to get GammaScoutUtil running:
   
- Python 3.0 or greater
- pyserial


	sudo apt-get install python3 python3-serial

### Getting Started

After plugging in the Gamma Scout into your USB port, check with dmesg which
device it is recognized as. Usually this will be /dev/ttyUSB0. Then, you can
call gammascoututil to check if it finds your Gamma Scout. Putting the Gamma
Scout into PC mode beforehand is actually not necessary, the software takes care
of that.

#### Usage

	gammascoututil <options> <commands>

	Options:

	-d Device     Specifies the serial device that the Gamma Scout is connected
	              to. Default is /dev/ttyUSB0.
	-p Protocol   Specifies the device protocol the connected Gamma Scout uses.
	              Either 'v1' or 'v2'. Default is 'v2'.
	-v            Outputs debug information.
	--help        Displays this help page.

	Commands:

	identify
	    Displays information like the Gamma Scout software version and serial
	    number of the device.
	synctime
	    Synchronizes the time with the current local system time.
	syncutctime
	    Synchronizes the time with the current time in UTC (GMT+0).
	settime:YYYY-MM-DD-HH-MM-SS
	    Sets the time to the user defined value.
	readlog:[txt|sqlite|csv|xml|bin]:[Filename]
	    Reads out Gamma Scout log in text format, sqlite format, CSV, XML or
	    binary format and writes the results to the specified filename.
	clearlog
	    Deletes the Gamma Scout log.
	readcfg:Filename
	    Reads out the configuration blob and writes it in the specified file in
	    binary format.
	devicereset
	    Completely resets the device to its factory defaults. Do not perform
	    this operation unless you have a good reason to.
 