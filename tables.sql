CREATE TABLE `log` (
  `interval_start` datetime NOT NULL,
  `interval_end` datetime NOT NULL,
  `counter` int(10) unsigned NOT NULL,
  PRIMARY KEY (`interval_start`),
  KEY `Index_interval_end` (`interval_end`),
  KEY `Index_counter` (`counter`)
) ENGINE=InnoDB;

CREATE VIEW `view_odl` AS SELECT
  CONCAT(DATE(`interval_start`), ' ', HOUR(`interval_start`), ':00:00') AS time,
  (`counter` / TIMESTAMPDIFF(MINUTE, `interval_start`, `interval_end`)) / 142 AS dosage
  FROM `log` WHERE `interval_start` >= '2020-03-25';
