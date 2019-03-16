CREATE TABLE `log` (
  `interval_start` datetime NOT NULL,
  `interval_end` datetime NOT NULL,
  `counter` int(10) unsigned NOT NULL,
  PRIMARY KEY (`interval_start`),
  KEY `Index_interval_end` (`interval_end`),
  KEY `Index_counter` (`counter`)
) ENGINE=InnoDB;
